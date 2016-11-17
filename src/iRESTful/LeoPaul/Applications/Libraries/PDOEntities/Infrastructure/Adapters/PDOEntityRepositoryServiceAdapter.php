<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Entities\Adapters\EntityRepositoryServiceAdapter;

final class PDOEntityRepositoryServiceAdapter implements EntityRepositoryServiceAdapter {
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

    public function fromClassNameToObject($className) {
        return new $className(
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
    }

}
