<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Factories;
use iRESTful\Rodson\Domain\Inputs\Repositories\Factories\RodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Repositories\ConcreteRodsonRepository;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRodsonAdapterFactoryAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRodsonRetrieverCriteriaAdapter;

final class ConcreteRodsonRepositoryFactory implements RodsonRepositoryFactory {

    public function __construct() {

    }

    public function create() {
        $adapterFactoryAdapter = new ConcreteRodsonAdapterFactoryAdapter();
        $criteriaAdapter = new ConcreteRodsonRetrieverCriteriaAdapter();
        return new ConcreteRodsonRepository($adapterFactoryAdapter, $criteriaAdapter);

    }

}
