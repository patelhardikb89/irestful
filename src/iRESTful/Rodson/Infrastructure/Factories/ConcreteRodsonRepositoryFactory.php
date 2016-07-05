<?php
namespace iRESTful\Rodson\Infrastructure\Factories;
use iRESTful\Rodson\Domain\Repositories\Factories\RodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Repositories\ConcreteRodsonRepository;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRodsonAdapterFactoryAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRodsonRetrieverCriteriaAdapter;

final class ConcreteRodsonRepositoryFactory implements RodsonRepositoryFactory {

    public function __construct() {

    }

    public function create() {
        $adapterFactoryAdapter = new ConcreteRodsonAdapterFactoryAdapter();
        $criteriaAdapter = new ConcreteRodsonRetrieverCriteriaAdapter();
        return new ConcreteRodsonRepository($adapterFactoryAdapter, $criteriaAdapter);

    }

}
