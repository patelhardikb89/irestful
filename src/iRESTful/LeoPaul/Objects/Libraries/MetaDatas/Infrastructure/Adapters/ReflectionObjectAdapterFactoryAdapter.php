<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\Adapters\ObjectAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ReflectionObjectAdapterFactoryAdapter implements ObjectAdapterFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToObjectAdapterFactory(array $data) {

        if (!isset($data['transformer_objects'])) {
            throw new ObjectException('The transformer_objects keyname is mandatory in order to convert data to an ObjectAdapterFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new ObjectException('The container_class_mapper keyname is mandatory in order to convert data to an ObjectAdapterFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new ObjectException('The interface_class_mapper keyname is mandatory in order to convert data to an ObjectAdapterFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new ObjectException('The delimiter keyname is mandatory in order to convert data to an ObjectAdapterFactory object.');
        }

        return new ReflectionObjectAdapterFactory(
            $data['transformer_objects'],
            $data['container_class_mapper'],
            $data['interface_class_mapper'],
            $data['delimiter']
        );

    }

}
