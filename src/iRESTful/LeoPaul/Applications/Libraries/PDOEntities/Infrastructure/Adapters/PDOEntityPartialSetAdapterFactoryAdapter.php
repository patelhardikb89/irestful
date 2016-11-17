<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\Adapters\EntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetAdapterFactory;

final class PDOEntityPartialSetAdapterFactoryAdapter implements EntityPartialSetAdapterFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntityPartialSetAdapterFactory(array $data) {

        if (!isset($data['transformer_objects'])) {
            throw new EntityPartialSetException('The transformer_objects keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntityPartialSetException('The container_class_mapper keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntityPartialSetException('The interface_class_mapper keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntityPartialSetException('The delimiter keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['timezone'])) {
            throw new EntityPartialSetException('The timezone keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['driver'])) {
            throw new EntityPartialSetException('The driver keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['hostname'])) {
            throw new EntityPartialSetException('The hostname keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['database'])) {
            throw new EntityPartialSetException('The database keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['username'])) {
            throw new EntityPartialSetException('The username keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['password'])) {
            return new PDOEntityPartialSetAdapterFactory(
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

        return new PDOEntityPartialSetAdapterFactory(
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
