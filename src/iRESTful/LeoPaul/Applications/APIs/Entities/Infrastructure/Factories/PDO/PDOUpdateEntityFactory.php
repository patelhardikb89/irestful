<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Factories\ControllerFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters\EntityRepositoryServiceAdapter;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\UpdateEntity;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;

final class PDOUpdateEntityFactory implements ControllerFactory {
    private $adapter;
    private $objectAdapterFactory;
	public function __construct(EntityRepositoryServiceAdapter $adapter, ObjectAdapterFactory $objectAdapterFactory) {
        $this->adapter = $adapter;
        $this->objectAdapterFactory = $objectAdapterFactory;
	}

    public function create() {

        $responseAdapter = new ConcreteJsonControllerResponseAdapter();
        $repositoryFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRepositoryFactory');
        $serviceFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityServiceWithSubEntitiesFactory');
        $adapterFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory');

        return new UpdateEntity($responseAdapter, $repositoryFactory, $serviceFactory, $adapterFactory, $this->objectAdapterFactory);
    }

}
