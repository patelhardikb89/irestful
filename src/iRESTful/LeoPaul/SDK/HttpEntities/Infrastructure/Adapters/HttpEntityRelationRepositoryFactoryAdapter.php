<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\Adapters\EntityRelationRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityRelationRepositoryFactory;

final class HttpEntityRelationRepositoryFactoryAdapter implements EntityRelationRepositoryFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToEntityRelationRepositoryFactory(array $data) {
        if (!isset($data['transformer_objects'])) {
            throw new EntityRelationException('The transformer_objects keyname is mandatory in order to convert data to an EntityRelationRepositoryFactory object.');
        }

        if (!isset($data['container_class_mapper'])) {
            throw new EntityRelationException('The container_class_mapper keyname is mandatory in order to convert data to an EntityRelationRepositoryFactory object.');
        }

        if (!isset($data['interface_class_mapper'])) {
            throw new EntityRelationException('The interface_class_mapper keyname is mandatory in order to convert data to an EntityRelationRepositoryFactory object.');
        }

        if (!isset($data['delimiter'])) {
            throw new EntityRelationException('The delimiter keyname is mandatory in order to convert data to an EntityRelationRepositoryFactory object.');
        }

        if (!isset($data['base_url'])) {
            throw new EntityRelationException('The base_url keyname is mandatory in order to convert data to an EntityRelationRepositoryFactory object.');
        }

        if (!isset($data['port']) && !isset($data['headers'])) {
            return new HttpEntityRelationRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url']
            );
        }

        if (!isset($data['port'])) {
            return new HttpEntityRelationRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                $data['headers']
            );
        }

        if (!isset($data['headers'])) {
            return new HttpEntityRelationRepositoryFactory(
                $data['transformer_objects'],
                $data['container_class_mapper'],
                $data['interface_class_mapper'],
                $data['delimiter'],
                $data['base_url'],
                null,
                $data['port']
            );
        }

        return new HttpEntityRelationRepositoryFactory(
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
