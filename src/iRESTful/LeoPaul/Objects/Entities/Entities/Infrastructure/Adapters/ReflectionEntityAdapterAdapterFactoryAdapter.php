<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\Factories\Adapters\EntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ReflectionEntityAdapterAdapterFactory;

final class ReflectionEntityAdapterAdapterFactoryAdapter implements EntityAdapterAdapterFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntityAdapterAdapterFactory(array $data) {

        if (!isset($data['transformer_objects'])) {
            throw new EntityException('The transformer_objects keyname is mandatory in order to convert data to an EntityAdapterAdapterFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntityException('The container_class_mapper keyname is mandatory in order to convert data to an EntityAdapterAdapterFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntityException('The interface_class_mapper keyname is mandatory in order to convert data to an EntityAdapterAdapterFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntityException('The delimiter keyname is mandatory in order to convert data to an EntityAdapterAdapterFactory object.');
        }

        return new ReflectionEntityAdapterAdapterFactory($data['transformer_objects'], $data['container_class_mapper'], $data['interface_class_mapper'], $data['delimiter']);

    }

}
