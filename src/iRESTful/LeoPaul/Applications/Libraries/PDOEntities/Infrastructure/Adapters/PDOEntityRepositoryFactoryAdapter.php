<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\Adapters\EntityRepositoryFactoryAdapter;

final class PDOEntityRepositoryFactoryAdapter implements EntityRepositoryFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntityRepositoryFactory(array $data) {

        if (!isset($data['transformer_objects'])) {
            throw new EntityException('The transformer_objects keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntityException('The container_class_mapper keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntityException('The interface_class_mapper keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntityException('The delimiter keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['timezone'])) {
            throw new EntityException('The timezone keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['driver'])) {
            throw new EntityException('The driver keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['hostname'])) {
            throw new EntityException('The hostname keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['database'])) {
            throw new EntityException('The database keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['username'])) {
            throw new EntityException('The username keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['password'])) {
            return new PDOEntityRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['timezone'],
                $data['driver'],
                $data['hostname'],
                $data['database'],
                $data['username']
            );
        }

        return new PDOEntityRepositoryFactory(
            $data['transformer_objects'],
            $data['container_class_mapper'],
            $data['interface_class_mapper'],
            $data['delimiter'],
            $data['timezone'],
            $data['driver'],
            $data['hostname'],
            $data['database'],
            $data['username'],
            $data['password']
        );

    }

}
