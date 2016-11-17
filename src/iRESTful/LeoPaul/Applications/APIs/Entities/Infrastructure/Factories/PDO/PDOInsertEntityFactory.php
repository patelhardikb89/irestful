<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Factories\ControllerFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters\EntityRepositoryServiceAdapter;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\InsertEntity;

final class PDOInsertEntityFactory implements ControllerFactory {
    private $adapter;
	public function __construct(EntityRepositoryServiceAdapter $adapter) {
        $this->adapter = $adapter;
	}

    public function create() {

        $responseAdapter = new ConcreteJsonControllerResponseAdapter();
        $serviceFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityServiceWithSubEntitiesFactory');
        $adapterFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory');

        return new InsertEntity($responseAdapter, $serviceFactory, $adapterFactory);

    }

}
