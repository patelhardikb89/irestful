<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryBuilderFactory;

final class PDOEntityRepositoryFactory implements EntityRepositoryFactory {
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
            $keynameAdapter = new ConcreteKeynameAdapter();
            $entityRetrieverCriteriaAdapter = new ConcreteEntityRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter);
            $requestAdapter = new ConcreteRequestAdapter($entityRetrieverCriteriaAdapter, $uuidAdapter);

            $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
            $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory([
                'transformer_objects' => $this->transformerObjects,
                'container_class_mapper' => $this->containerClassMapper,
                'interface_class_mapper' => $this->interfaceClassMapper,
                'delimiter' => $this->delimiter
            ])->create();

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

            $entityRepository = new PDOEntityRepository($pdoRepository, $requestAdapter);
            $entityRelationRepository = $entityRelationRepositoryBuilderFactory->create()
                                                                                ->withRequestRelationAdapter($requestRelationAdapter)
                                                                                ->withPDORepository($pdoRepository)
                                                                                ->withEntityRepository($entityRepository)
                                                                                ->now();

            $pdoAdapterAdapter = new ConcretePDOAdapterAdapter($entityAdapterAdapter, null, $entityRelationRepository);
            $entityRepository->addPDOAdapterAdapter($pdoAdapterAdapter);
            return $entityRepository;

        } catch (PDOException $exception) {
            throw new EntityException('There was an exception while converting data to a PDORepository object.', $exception);
        }

    }

}
