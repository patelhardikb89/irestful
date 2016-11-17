<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\Factories\SubEntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories\ConcreteSubEntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;

final class PDOSubEntityRepositoryFactory implements SubEntityRepositoryFactory {
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
            $entityAdapter = $entityAdapterFactory->create();

            return new ConcreteSubEntityRepository($entityRepository, $entityAdapter);

        } catch (EntityException $exception) {
            throw new SubEntityException('There was an Entity exception.', $exception);
        }

    }

}
