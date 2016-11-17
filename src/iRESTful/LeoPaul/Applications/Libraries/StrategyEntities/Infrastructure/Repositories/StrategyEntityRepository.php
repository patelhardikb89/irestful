<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class StrategyEntityRepository implements EntityRepository {
    private $criteriaAdapter;
    private $containerRepositoriesMapper;
    public function __construct(EntityRetrieverCriteriaAdapter $criteriaAdapter, array $containerRepositoriesMapper) {
        $this->criteriaAdapter = $criteriaAdapter;
        $this->containerRepositoriesMapper = $containerRepositoriesMapper;
    }

    public function exists(array $data) {
        $repository = $this->fetchRepository($data);
        return $repository->exists($data);
    }

    public function retrieve(array $data) {
        $repository = $this->fetchRepository($data);
        return $repository->retrieve($data);
    }

    private function fetchRepository(array $data) {
        $criteria = $this->criteriaAdapter->fromDataToRetrieverCriteria($data);
        $containerName = $criteria->getContainerName();

        if (!isset($this->containerRepositoriesMapper[$containerName])) {
            throw new EntityException('The containerName ('.$containerName.') does not have a matching repository in the mapper.');
        }

        return $this->containerRepositoriesMapper[$containerName];
    }

}
