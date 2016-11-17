<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityRelationRepository;

final class StrategyEntityRelationRepositoryFactory implements EntityRelationRepositoryFactory {
    private $containerRepositoryMapper;
    public function __construct(array $containerRepositoryMapper) {
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function create() {
        $uuidAdapter = new ConcreteUuidAdapter();
        $entityRelationRetrieverCriteriaAdapter = new ConcreteEntityRelationRetrieverCriteriaAdapter($uuidAdapter);
        return new StrategyEntityRelationRepository($entityRelationRetrieverCriteriaAdapter, $this->containerRepositoryMapper);
    }

}
