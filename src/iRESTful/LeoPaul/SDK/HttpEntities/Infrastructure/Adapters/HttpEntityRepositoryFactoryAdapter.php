<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\Adapters\EntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityRepositoryFactory;

final class HttpEntityRepositoryFactoryAdapter implements EntityRepositoryFactoryAdapter {

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

        if (!isset($data['base_url'])) {
            throw new EntityException('The base_url keyname is mandatory in order to convert data to an EntityRepositoryFactory object.');
        }

        if (!isset($data['port']) && !isset($data['headers'])) {
            return new HttpEntityRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url']
            );
        }

        if (!isset($data['port'])) {
            return new HttpEntityRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                $data['headers']
            );
        }

        if (!isset($data['headers'])) {
            return new HttpEntityRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                null,
                $data['port']
            );
        }

        return new HttpEntityRepositoryFactory(
            $data['transformer_objects'],
            $data['container_class_mapper'],
            $data['interface_class_mapper'],
            $data['delimiter'],
            $data['base_url'],
            $data['headers'],
            $data['port']
        );
    }

}
