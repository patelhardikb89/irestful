<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;

final class StrategyEntityPartialSetRepositoryFactory implements EntityPartialSetRepositoryFactory {
    private $containerRepositoryMapper;
    public function __construct(array $containerRepositoryMapper) {
        $this->containerRepositoryMapper = $containerRepositoryMapper;
    }

    public function create() {
        $orderingAdapter = new ConcreteOrderingAdapter();
        $entityPartialSetRetrieverCriteriaAdapter = new ConcreteEntityPartialSetRetrieverCriteriaAdapter($orderingAdapter);
        return new StrategyEntityPartialSetRepository($entityPartialSetRetrieverCriteriaAdapter, $this->containerRepositoryMapper);
    }

}
