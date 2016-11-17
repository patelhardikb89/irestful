<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\Adapters\EntityPartialSetAdapterFactoryAdapter;

final class HttpEntityPartialSetAdapterFactoryAdapter implements EntityPartialSetAdapterFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntityPartialSetAdapterFactory(array $data) {

        if (!isset($data['transformer_objects'])) {
            throw new EntityPartialSetException('The transformer_objects keyname is mandatory in order to convert data to an EntityPartialSetAdapterFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntityPartialSetException('The container_class_mapper keyname is mandatory in order to convert data to an EntityPartialSetAdapterFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntityPartialSetException('The interface_class_mapper keyname is mandatory in order to convert data to an EntityPartialSetAdapterFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntityPartialSetException('The delimiter keyname is mandatory in order to convert data to an EntityPartialSetAdapterFactory object.');
        }

        if (!isset($data['base_url'])) {
            throw new EntityPartialSetException('The base_url keyname is mandatory in order to convert data to an EntityPartialSetAdapterFactory object.');
        }

        if (!isset($data['port']) && !isset($data['headers'])) {
            return new HttpEntityPartialSetAdapterFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url']
            );
        }

        if (!isset($data['port'])) {
            return new HttpEntityPartialSetAdapterFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                $data['headers']
            );
        }

        if (!isset($data['headers'])) {
            return new HttpEntityPartialSetAdapterFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                null,
                $data['port']
            );
        }

        return new HttpEntityPartialSetAdapterFactory(
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
