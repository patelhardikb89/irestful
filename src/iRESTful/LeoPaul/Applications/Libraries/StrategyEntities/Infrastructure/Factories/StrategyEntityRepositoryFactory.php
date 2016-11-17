<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRetrieverCriteriaAdapter;

final class StrategyEntityRepositoryFactory implements EntityRelationRepositoryFactory {
    private $containerRepositoryMapper;
    public function __construct(array $containerRepositoryMapper) {
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function create() {
        $uuidAdapter = new ConcreteUuidAdapter();
        $keynameAdapter = new ConcreteKeynameAdapter();
        $entityRetrieverCriteriaAdapter = new ConcreteEntityRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter);
        return new StrategyEntityRepository($entityRetrieverCriteriaAdapter, $this->containerRepositoryMapper);
    }

}
