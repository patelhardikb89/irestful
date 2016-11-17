<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\Adapters\ClassMetaDataRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassMetaDataRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ReflectionClassMetaDataRepositoryFactoryAdapter implements ClassMetaDataRepositoryFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToClassMetaDataRepositoryFactory(array $data) {

        if (!isset($data['container_class_mapper'])) {
            throw new ClassMetaDataException('The container_class_mapper keyname is mandatory in order to convert data to an ClassMetaDataRepositoryFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new ClassMetaDataException('The interface_class_mapper keyname is mandatory in order to convert data to an ClassMetaDataRepositoryFactory object.');
        }

        return new ReflectionClassMetaDataRepositoryFactory($data['container_class_mapper'], $data['interface_class_mapper']);

    }

}
