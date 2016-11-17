<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Factories\ControllerFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\DeleteSet;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters\EntityRepositoryServiceAdapter;

final class PDODeleteSetFactory implements ControllerFactory {
    private $adapter;
	public function __construct(EntityRepositoryServiceAdapter $adapter) {
        $this->adapter = $adapter;
	}

    public function create() {

        $responseAdapter = new ConcreteJsonControllerResponseAdapter();
        $repositorySetFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetRepositoryFactory');
        $serviceSetFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetServiceWithSubEntitiesFactory');
        $adapterFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory');

        return new DeleteSet($responseAdapter, $repositorySetFactory, $serviceSetFactory, $adapterFactory);
    }

}
