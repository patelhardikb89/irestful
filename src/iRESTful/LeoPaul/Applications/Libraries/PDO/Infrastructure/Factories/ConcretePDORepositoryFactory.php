<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\PDORepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Repositories\ConcretePDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOServiceFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteRequestAdapterFactory;

final class ConcretePDORepositoryFactory implements PDORepositoryFactory {
    private $timezone;
    private $driver;
    private $hostname;
    private $database;
    private $username;
    private $password;
    public function __construct($timezone, $driver, $hostname, $database, $username, $password = null) {
        $this->timezone = $timezone;
        $this->driver = $driver;
        $this->hostname = $hostname;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function create() {

        $pdoAdapterFactoryAdapter = new ConcretePDOAdapterFactoryAdapter();
        $pdoAdapter = $pdoAdapterFactoryAdapter->fromDataToPDOAdapterFactory([
            'timezone' => $this->timezone,
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password
        ])->create();

        $pdoServiceFactoryAdapter = new ConcretePDOServiceFactoryAdapter();
        $pdoService = $pdoServiceFactoryAdapter->fromDataToPDOServiceFactory([
            'timezone' => $this->timezone,
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password
        ])->create();

        $requestAdapterFactory = new ConcreteRequestAdapterFactory();
        $requestAdapter = $requestAdapterFactory->create();

        return new ConcretePDORepository($pdoAdapter, $pdoService, $requestAdapter);

    }

}
