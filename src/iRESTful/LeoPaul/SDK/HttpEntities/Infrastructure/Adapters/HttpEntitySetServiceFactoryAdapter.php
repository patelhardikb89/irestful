<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\Adapters\EntitySetServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntitySetServiceFactory;

final class HttpEntitySetServiceFactoryAdapter implements EntitySetServiceFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntitySetServiceFactory(array $data) {
        if (!isset($data['transformer_objects'])) {
            throw new EntitySetException('The transformer_objects keyname is mandatory in order to convert data to an EntitySetServiceFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntitySetException('The container_class_mapper keyname is mandatory in order to convert data to an EntitySetServiceFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntitySetException('The interface_class_mapper keyname is mandatory in order to convert data to an EntitySetServiceFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntitySetException('The delimiter keyname is mandatory in order to convert data to an EntitySetServiceFactory object.');
        }

        if (!isset($data['base_url'])) {
            throw new EntitySetException('The base_url keyname is mandatory in order to convert data to an EntitySetServiceFactory object.');
        }

        if (!isset($data['port']) && !isset($data['headers'])) {
            return new HttpEntitySetServiceFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url']
            );
        }

        if (!isset($data['port'])) {
            return new HttpEntitySetServiceFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                $data['headers']
            );
        }

        if (!isset($data['headers'])) {
            return new HttpEntitySetServiceFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                null,
                $data['port']
            );
        }

        return new HttpEntitySetServiceFactory(
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
