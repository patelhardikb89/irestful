<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryBuilderFactory;

final class PDOEntityAdapterFactory implements EntityAdapterFactory {
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

        $pdoRepositoryFactoryAdapter = new ConcretePDORepositoryFactoryAdapter();
        $pdoRepository = $pdoRepositoryFactoryAdapter->fromDataToPDORepositoryFactory([
            'timezone' => $this->timezone,
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password
        ])->create();

        $uuidAdapter = new ConcreteUuidAdapter();
        $entityRelationRetrieverCriteriaAdapter = new ConcreteEntityRelationRetrieverCriteriaAdapter($uuidAdapter);
        $requestRelationAdapter = new ConcreteRequestRelationAdapter($entityRelationRetrieverCriteriaAdapter);
        $entityRelationRepositoryBuilderFactory = new PDOEntityRelationRepositoryBuilderFactory(
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

        $entityRelationRepository = $entityRelationRepositoryBuilderFactory->create()
                                                                            ->withRequestRelationAdapter($requestRelationAdapter)
                                                                            ->withPDORepository($pdoRepository)
                                                                            ->withEntityRepository($entityRepository)
                                                                            ->now();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
            'transformer_objects' => $this->transformerObjects,
            'container_class_mapper' => $this->containerClassMapper,
            'interface_class_mapper' => $this->interfaceClassMapper,
            'delimiter' => $this->delimiter
        ])->create();

        return $entityAdapterAdapter->fromRepositoriesToEntityAdapter($entityRepository, $entityRelationRepository);
    }

}
