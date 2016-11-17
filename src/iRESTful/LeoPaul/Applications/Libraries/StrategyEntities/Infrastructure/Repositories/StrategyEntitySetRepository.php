<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class StrategyEntitySetRepository implements EntitySetRepository {
    private $criteriaAdapter;
    private $containerRepositoryMapper;
    public function __construct(EntitySetRetrieverCriteriaAdapter $criteriaAdapter, array $containerRepositoryMapper) {
        $this->criteriaAdapter = $criteriaAdapter;
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function retrieve(array $data) {
        $criteria = $this->criteriaAdapter->fromDataToEntitySetRetrieverCriteria($data);
        $containerName = $criteria->getContainerName();

        if (!isset($this->containerRepositoryMapper[$containerName])) {
            throw new EntitySetException('The containerName ('.$containerName.') does not have a matching repository in the mapper.');
        }

        $repository = $this->containerRepositoryMapper[$containerName];
        return $repository->retrieve($data);
    }

}
