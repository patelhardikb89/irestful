<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\Factories\SubEntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories\ConcreteSubEntitySetRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOSubEntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;

final class PDOSubEntitySetRepositoryFactory implements SubEntitySetRepositoryFactory {
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

        $subEntityRepositoryFactory = new PDOSubEntityRepositoryFactory(
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
        $subEntityRepository = $subEntityRepositoryFactory->create();

        return new ConcreteSubEntitySetRepository($subEntityRepository);
    }

}
