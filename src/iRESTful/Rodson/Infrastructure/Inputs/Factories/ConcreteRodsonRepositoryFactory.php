<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Factories;
use iRESTful\Rodson\Domain\Inputs\Repositories\Factories\RodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Repositories\ConcreteRodsonRepository;
use iRESTful\Rodson\Infrastructure\Inputs\Factories\ConcreteRodsonAdapterFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRodsonRetrieverCriteriaAdapter;

final class ConcreteRodsonRepositoryFactory implements RodsonRepositoryFactory {

    public function __construct() {

    }

    public function create() {
        $adapterFactory = new ConcreteRodsonAdapterFactory();
        $adapter = $adapterFactory->create();

        $criteriaAdapter = new ConcreteRodsonRetrieverCriteriaAdapter();
        return new ConcreteRodsonRepository($adapter, $criteriaAdapter);
    }

}
