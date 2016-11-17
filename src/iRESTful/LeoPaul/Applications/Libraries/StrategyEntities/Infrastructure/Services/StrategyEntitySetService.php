<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class StrategyEntitySetService implements EntitySetService {
    private $entityAdapter;
    private $containerServiceSetMapper;
    public function __construct(EntityAdapter $entityAdapter, array $containerServiceSetMapper) {
        $this->entityAdapter = $entityAdapter;
        $this->containerServiceSetMapper = $containerServiceSetMapper;
    }

    public function insert(array $entities) {
        $services = $this->fetchServices($entities);
        foreach($services as $oneService) {
            $oneService['service']->insert($oneService['entities']);
        }

    }

    public function update(array $originalEntities, array $updatedEntities) {
        $services = $this->fetchServices($originalEntities, $updatedEntities);
        foreach($services as $oneService) {
            $oneService['service']->update($oneService['entities'], $oneService['updated_entities']);
        }
    }

    public function delete(array $entities) {
        $services = $this->fetchServices($entities);
        foreach($services as $oneService) {
            $oneService['service']->delete($oneService['entities']);
        }
    }

    private function fetchServices(array $entities, array $updatedEntities = null) {

        try {

            $output = [];
            $containerNames = $this->entityAdapter->fromEntitiesToContainerNames($entities);
            foreach($containerNames as $index => $oneContainerName) {

                if (!isset($this->containerServiceSetMapper[$oneContainerName])) {
                    throw new EntitySetException('The containerName ('.$oneContainerName.') does not have a matching service in the mapper.');
                }

                if (!isset($output[$oneContainerName])) {
                    $output[$oneContainerName] = [
                        'entities' => [],
                        'updated_entities' => [],
                        'service' => $this->containerServiceSetMapper[$oneContainerName]
                    ];
                }

                $output[$oneContainerName]['entities'][] = $entities[$index];
                if (!empty($updatedEntities) && isset($updatedEntities[$index])) {
                    $output[$oneContainerName]['updated_entities'][] = $updatedEntities[$index];
                }
            }

            return $output;

        } catch (EntityException $exception) {
            throw new EntitySetException('There was an exception while converting entities to containerNames.', $exception);
        }

    }

}
