<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntitySetRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\ConcretePDOAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryFactory;

final class PDOEntitySetRepositoryFactory implements EntitySetRepositoryFactory {
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
            $orderingAdapter = new ConcreteOrderingAdapter();
            $entitySetRetrieverCriteriaAdapter = new ConcreteEntitySetRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter, $orderingAdapter);
            $requestSetAdapter = new ConcreteRequestSetAdapter($entitySetRetrieverCriteriaAdapter, $uuidAdapter);

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

            $pdoAdapterFactory = new ConcretePDOAdapterFactory($entityAdapterAdapter, $entityRepository, $entityRelationRepository);
            return new PDOEntitySetRepository($pdoRepository, $requestSetAdapter, $pdoAdapterFactory);

        } catch (PDOException $exception) {
            throw new EntitySetException('There was an exception while converting sata to a PDORepository object.', $exception);
        } catch (EntityException $exception) {
            throw new EntitySetException('There was an exception while converting data to an EntityRepository object.', $exception);
        }
    }

}
