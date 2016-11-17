<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\PDOServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\Adapters\PDOServiceFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteRequestAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteNativePDOFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDOTransactionAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Services\ConcretePDOService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Exceptions\NativePDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOAdapterFactoryAdapter;

final class ConcretePDOServiceFactory implements PDOServiceFactory {
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

        $transactionAdapterFactory = new ConcretePDOTransactionAdapterFactory($this->timezone);
        $transactionAdapter = $transactionAdapterFactory->create();

        $nativePDOFactory = new ConcreteNativePDOFactory($this->driver, $this->hostname, $this->database, $this->username, $this->password);

        $pdoAdapterFactoryAdapter = new ConcretePDOAdapterFactoryAdapter();
        $pdoAdapter = $pdoAdapterFactoryAdapter->fromDataToPDOAdapterFactory([
            'timezone' => $this->timezone,
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password
        ])->create();

        $requestAdapterFactory = new ConcreteRequestAdapterFactory();
        $requestAdapter = $requestAdapterFactory->create();

        try {

            $nativePDO = $nativePDOFactory->create();
            $pdo = $nativePDO->getPDO();
            return new ConcretePDOService($transactionAdapter, $pdoAdapter, $requestAdapter, $pdo);

        } catch (NativePDOException $exception) {
            throw new PDOException('There was an exception while creating a NativePDO object.', $exception);
        }
    }

}
