<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\Adapters\EntityServiceFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class HttpEntityServiceFactoryAdapter implements EntityServiceFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntityServiceFactory(array $data) {
        if (!isset($data['transformer_objects'])) {
            throw new EntityException('The transformer_objects keyname is mandatory in order to convert data to an EntityServiceFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntityException('The container_class_mapper keyname is mandatory in order to convert data to an EntityServiceFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntityException('The interface_class_mapper keyname is mandatory in order to convert data to an EntityServiceFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntityException('The delimiter keyname is mandatory in order to convert data to an EntityServiceFactory object.');
        }

        if (!isset($data['base_url'])) {
            throw new EntityException('The base_url keyname is mandatory in order to convert data to an EntityServiceFactory object.');
        }

        if (!isset($data['port']) && !isset($data['headers'])) {
            return new HttpEntityServiceFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url']
            );
        }

        if (!isset($data['port'])) {
            return new HttpEntityServiceFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                $data['headers']
            );
        }

        if (!isset($data['headers'])) {
            return new HttpEntityServiceFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                null,
                $data['port']
            );
        }

        return new HttpEntityServiceFactory(
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
