<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Factories\ControllerFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\UpdateSet;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters\EntityRepositoryServiceAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;

final class PDOUpdateSetEntityFactory implements ControllerFactory {
    private $adapter;
    private $objectAdapterFactory;
	public function __construct(EntityRepositoryServiceAdapter $adapter, ObjectAdapterFactory $objectAdapterFactory) {
        $this->adapter = $adapter;
        $this->objectAdapterFactory = $objectAdapterFactory;
	}

    public function create() {

        $responseAdapter = new ConcreteJsonControllerResponseAdapter();
        $repositorySetFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetRepositoryFactory');
        $serviceSetFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetServiceWithSubEntitiesFactory');
        $adapterFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory');

        return new UpdateSet($responseAdapter, $repositorySetFactory, $serviceSetFactory, $adapterFactory, $this->objectAdapterFactory);
    }

}
