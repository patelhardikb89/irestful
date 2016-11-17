<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Factories\ControllerFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters\EntityRepositoryServiceAdapter;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveEntityPartialSet;

final class PDORetrieveEntityPartialSetFactory implements ControllerFactory {
    private $adapter;
	public function __construct(EntityRepositoryServiceAdapter $adapter) {
        $this->adapter = $adapter;
	}

    public function create() {

        $responseAdapter = new ConcreteJsonControllerResponseAdapter();
        $repositoryFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetRepositoryFactory');
        $adapterFactory = $this->adapter->fromClassNameToObject('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetAdapterFactory');

        return new RetrieveEntityPartialSet($responseAdapter, $repositoryFactory, $adapterFactory);
    }

}
