<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\Adapters\PDOServiceFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDOServiceFactory;

final class ConcretePDOServiceFactoryAdapter implements PDOServiceFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToPDOServiceFactory(array $data) {

        if (!isset($data['timezone'])) {
            throw new PDOException('The timezone is mandatory in order to convert data to a PDOServiceFactoryFactory object.');
        }

        if (!isset($data['driver'])) {
            throw new PDOException('The driver is mandatory in order to convert data to a PDOServiceFactoryFactory object.');
        }

        if (!isset($data['hostname'])) {
            throw new PDOException('The hostname is mandatory in order to convert data to a PDOServiceFactoryFactory object.');
        }

        if (!isset($data['database'])) {
            throw new PDOException('The database is mandatory in order to convert data to a PDOServiceFactoryFactory object.');
        }

        if (!isset($data['username'])) {
            throw new PDOException('The username is mandatory in order to convert data to a PDOServiceFactoryFactory object.');
        }

        if (!isset($data['password'])) {
            return new ConcretePDOServiceFactory(
                $data['timezone'],
                $data['driver'],
                $data['hostname'],
                $data['database'],
                $data['username']
            );
        }

        return new ConcretePDOServiceFactory(
            $data['timezone'],
            $data['driver'],
            $data['hostname'],
            $data['database'],
            $data['username'],
            $data['password']
        );

    }

}
