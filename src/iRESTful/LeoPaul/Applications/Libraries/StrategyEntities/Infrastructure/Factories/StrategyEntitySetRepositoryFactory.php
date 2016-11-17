<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntitySetRepository;

final class StrategyEntitySetRepositoryFactory implements EntitySetRepositoryFactory {
    private $containerRepositoryMapper;
    public function __construct(array $containerRepositoryMapper) {
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function create() {
        $uuidAdapter = new ConcreteUuidAdapter();
        $keynameAdapter = new ConcreteKeynameAdapter();
        $orderingAdapter = new ConcreteOrderingAdapter();
        $entitySetRetrieverCriteriaAdapter = new ConcreteEntitySetRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter, $orderingAdapter);
        return new StrategyEntitySetRepository($entitySetRetrieverCriteriaAdapter, $this->containerRepositoryMapper);
    }

}
