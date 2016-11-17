<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteServerFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteServerAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteClientAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteMicroDateTimeClosureAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories\ConcreteMicroDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteMicroDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteNativePDOFactory;

final class ConcretePDOAdapterFactory implements PDOAdapterFactory {
    private $timeZone;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $password;
    public function __construct($timeZone, $driver, $hostName, $database, $username, $password = null) {
        $this->timeZone = $timeZone;
        $this->driver = $driver;
        $this->hostName = $hostName;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function create() {

        try {

            $nativePDOFactory = new ConcreteNativePDOFactory($this->driver, $this->hostName, $this->database, $this->username, $this->password);

            $clientAdapter = new ConcreteClientAdapter();
            $serverAdapter = new ConcreteServerAdapter($clientAdapter);
            $serverFactory = new ConcreteServerFactory($serverAdapter, $nativePDOFactory);

            $dateTimeAdapter = new ConcreteDateTimeAdapter($this->timeZone);
            $microDateTimeAdapter = new ConcreteMicroDateTimeAdapter($dateTimeAdapter);
            $microDateTimeFactory = new ConcreteMicroDateTimeFactory($microDateTimeAdapter);
            $microDateTimeClosureAdapter = new ConcreteMicroDateTimeClosureAdapter($microDateTimeFactory);

            return new ConcretePDOAdapter($serverFactory, $microDateTimeClosureAdapter);

        } catch (DateTimeException $exception) {
            throw new PDOException('There was an exception while create a DateTimeAdapter object.', $exception);
        }
    }

}
