<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\Adapters\PDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDORepositoryFactory;

final class ConcretePDORepositoryFactoryAdapter implements PDORepositoryFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToPDORepositoryFactory(array $data) {
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
            return new ConcretePDORepositoryFactory(
                $data['timezone'],
                $data['driver'],
                $data['hostname'],
                $data['database'],
                $data['username']
            );
        }

        return new ConcretePDORepositoryFactory(
            $data['timezone'],
            $data['driver'],
            $data['hostname'],
            $data['database'],
            $data['username'],
            $data['password']
        );
    }

}
