<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityPartialSetAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\ConcretePDOAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryFactory;

final class PDOEntityPartialSetRepositoryFactory implements EntityPartialSetRepositoryFactory {
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

            $orderingAdapter = new ConcreteOrderingAdapter();
            $entityPartialSetRetrieverCriteriaAdapter = new ConcreteEntityPartialSetRetrieverCriteriaAdapter($orderingAdapter);
            $requestPartialSetAdapter = new ConcreteRequestPartialSetAdapter($entityPartialSetRetrieverCriteriaAdapter);

            $pdoRepositoryFactoryAdapter = new ConcretePDORepositoryFactoryAdapter();
            $pdoRepository = $pdoRepositoryFactoryAdapter->fromDataToPDORepositoryFactory([
                'timezone' => $this->timezone,
                'driver' => $this->driver,
                'hostname' => $this->hostname,
                'database' => $this->database,
                'username' => $this->username,
                'password' => $this->password
            ])->create();

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
            $entityPartialSetAdapter = new ConcreteEntityPartialSetAdapter($entityAdapter);

            $pdoAdapterFactory = new ConcretePDOAdapterFactory($entityAdapterAdapter, $entityRepository, $entityRelationRepository);
            return new PDOEntityPartialSetRepository($requestPartialSetAdapter, $entityPartialSetAdapter, $pdoRepository, $pdoAdapterFactory);

        } catch (PDOException $exception) {
            throw new EntityPartialSetException('There was an exception while converting data to a PDORepository object.', $exception);
        } catch (EntityException $exception) {
            throw new EntityPartialSetException('There was an exception while converting data to an EntityRepository object.', $exception);
        }

    }

}
