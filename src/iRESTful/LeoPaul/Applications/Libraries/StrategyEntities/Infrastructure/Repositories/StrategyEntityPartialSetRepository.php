<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class StrategyEntityPartialSetRepository implements EntityPartialSetRepository {
    private $criteriaAdapter;
    private $containerRepositoryMapper;
    public function __construct(EntityPartialSetRetrieverCriteriaAdapter $criteriaAdapter, array $containerRepositoryMapper) {
        $this->criteriaAdapter = $criteriaAdapter;
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function retrieve(array $data) {
        $criteria = $this->criteriaAdapter->fromDataToEntityPartialSetRetrieverCriteria($data);
        $containerName = $criteria->getContainerName();

        if (!isset($this->containerRepositoryMapper[$containerName])) {
            throw new EntityPartialSetException('The containerName ('.$containerName.') does not have a matching repository in the mapper.');
        }

        $repository = $this->containerRepositoryMapper[$containerName];
        return $repository->retrieve($data);
    }

}
