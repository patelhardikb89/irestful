<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Services\PDOEntityService;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOServiceFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestEntityWithSubEntitiesAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories\ConcreteSubEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories\ConcreteSubEntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteSubEntitiesAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestEntityRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryFactory;

final class PDOEntityServiceWithSubEntitiesFactory implements EntityServiceFactory {
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

        try {

            $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
            $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
                'transformer_objects' => $this->transformerObjects,
                'container_class_mapper' => $this->containerClassMapper,
                'interface_class_mapper' => $this->interfaceClassMapper,
                'delimiter' => $this->delimiter
            ])->create();

            $entityRepositoryFactoryAdapter = new PDOEntityRepositoryFactoryAdapter();
            $entityRepository = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory([
                'transformer_objects' => $this->transformerObjects,
                'container_class_mapper' => $this->containerClassMapper,
                'interface_class_mapper' => $this->interfaceClassMapper,
                'delimiter' => $this->delimiter,
                'timezone' => $this->timezone,
                'driver' => $this->driver,
                'hostname' => $this->hostname,
                'database' => $this->database,
                'username' => $this->username,
                'password' => $this->password
            ])->create();

            $entityRelationRepositoryFactory = new PDOEntityRelationRepositoryFactory(
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
            $entityRelationRepository = $entityRelationRepositoryFactory->create();

            $entityAdapter = $entityAdapterAdapter->fromRepositoriesToEntityAdapter($entityRepository, $entityRelationRepository);
            $reqiestEntityRelationAdapter = new ConcreteRequestEntityRelationAdapter($entityAdapter, $this->delimiter);
            $requestEntityAdapter = new ConcreteRequestEntityAdapter($reqiestEntityRelationAdapter, $entityAdapter);

            $subEntityRepository = new ConcreteSubEntityRepository($entityRepository, $entityAdapter);
            $subEntitySetRepository = new ConcreteSubEntitySetRepository($subEntityRepository);
            $subEntitiesAdapter = new ConcreteSubEntitiesAdapter($requestEntityAdapter);
            $requestEntityWithSubEntitiesAdapter = new ConcreteRequestEntityWithSubEntitiesAdapter(
                $subEntitySetRepository,
                $subEntityRepository,
                $subEntitiesAdapter,
                $requestEntityAdapter
            );

            $pdoServiceFactoryAdapter = new ConcretePDOServiceFactoryAdapter();
            $pdoService = $pdoServiceFactoryAdapter->fromDataToPDOServiceFactory([
                'timezone' => $this->timezone,
                'driver' => $this->driver,
                'hostname' => $this->hostname,
                'database' => $this->database,
                'username' => $this->username,
                'password' => $this->password
            ])->create();

            return new PDOEntityService($requestEntityWithSubEntitiesAdapter, $pdoService);

        } catch (PDOException $exception) {
            throw new EntityException('There was an exception while converting data to a PDOService object.', $exception);
        }
    }
}
