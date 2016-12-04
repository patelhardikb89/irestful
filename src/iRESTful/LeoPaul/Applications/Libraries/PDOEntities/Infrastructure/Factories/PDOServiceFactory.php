<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Factories\ServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects\ConcreteServiceRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects\ConcreteServiceService;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityServiceWithSubEntitiesFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetServiceWithSubEntitiesFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects\ConcreteServiceAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects\ConcreteService;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetAdapterFactory;

final class PDOServiceFactory implements ServiceFactory {
    private $transformerObjects;
	private $containerClassMapper;
	private $interfaceClassMapper;
	private $delimiter;
    private $timezone;
    private $driver;
    private $hostname;
    private $database;
    private $username;
    private $password;
	public function __construct(
        array $transformerObjects,
        array $containerClassMapper,
        array $interfaceClassMapper,
        $delimiter,
        $timezone,
        $driver,
        $hostname,
        $database,
        $username,
        $password = null
    ) {
		$this->transformerObjects = $transformerObjects;
		$this->containerClassMapper = $containerClassMapper;
		$this->interfaceClassMapper = $interfaceClassMapper;
		$this->delimiter = $delimiter;
        $this->timezone = $timezone;
        $this->driver = $driver;
        $this->hostname = $hostname;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
	}

    public function create() {

        $repositoryFactory = new PDOEntityRepositoryFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $setRepositoryFactory = new PDOEntitySetRepositoryFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $partialSetRepositoryFactory = new PDOEntityPartialSetRepositoryFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $relationRepositoryFactory = new PDOEntityRelationRepositoryFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $serviceFactory = new PDOEntityServiceWithSubEntitiesFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $setServiceFactory = new PDOEntitySetServiceWithSubEntitiesFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $entityAdapterFactory = new PDOEntityAdapterFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $entityPartialSetAdapterFactory = new PDOEntityPartialSetAdapterFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter,
            $this->timezone,
            $this->driver,
            $this->hostname,
            $this->database,
            $this->username,
            $this->password
        );

        $objectAdapterFactory = new ReflectionObjectAdapterFactory(
            $this->transformerObjects,
            $this->containerClassMapper,
            $this->interfaceClassMapper,
            $this->delimiter
        );

        $repository = new ConcreteServiceRepository(
            $repositoryFactory,
            $setRepositoryFactory,
            $partialSetRepositoryFactory,
            $relationRepositoryFactory
        );

        $service = new ConcreteServiceService(
            $serviceFactory,
            $setServiceFactory
        );

        $adapter = new ConcreteServiceAdapter(
            $entityAdapterFactory,
            $entityPartialSetAdapterFactory,
            $objectAdapterFactory
        );

        return new ConcreteService(
            $repository,
            $service,
            $adapter
        );
    }

}
