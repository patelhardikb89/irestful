<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class StrategyEntityRelationRepository implements EntityRelationRepository {
    private $criteriaAdapter;
    private $containerRepositoryMapper;
    public function __construct(EntityRelationRetrieverCriteriaAdapter $criteriaAdapter, array $containerRepositoryMapper) {
        $this->criteriaAdapter = $criteriaAdapter;
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function retrieve(array $data) {
        $criteria = $this->criteriaAdapter->fromDataToEntityRelationRetrieverCriteria($data);
        $containerName = $criteria->getMasterContainerName();
        if (!isset($this->containerRepositoryMapper[$containerName])) {
            throw new EntityRelationException('The masterContainerName ('.$containerName.') does not have a matching repository in the mapper.');
        }

        $repository = $this->containerRepositoryMapper[$containerName];
        return $repository->retrieve($data);
    }

}
