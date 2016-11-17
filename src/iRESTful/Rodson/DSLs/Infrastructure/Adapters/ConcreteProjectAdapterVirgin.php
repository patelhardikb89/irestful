<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Factories\ConcreteProjectAdapterFactory;
use iRESTful\Rodson\DSLs\Domain\Projects\Exceptions\ProjectException;

final class ConcreteProjectAdapterVirgin implements ProjectAdapter {

    public function __construct() {

    }

    public function fromDataToProject(array $data) {

        if (!isset($data['code']) || !is_array($data['code'])) {
            throw new ProjectException('The code keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['base_directory']) || !is_string($data['base_directory'])) {
            throw new ProjectException('The base_directory keyname is mandatory in order to convert data to a Project object.');
        }

        $converters = [];
        if (isset($data['converters']) && is_array($data['converters'])) {
            $converters = $data['converters'];
        }

        $types = [];
        if (isset($data['types']) && is_array($data['types'])) {
            $types = $data['types'];
        }

        $objects = [];
        if (isset($data['objects']) && is_array($data['objects'])) {
            $objects = $data['objects'];
        }

        $databases = [];
        if (isset($data['databases']) && is_array($data['databases'])) {
            $databases = $data['databases'];
        }

        $parents = [];
        if (isset($data['parents']) && is_array($data['parents'])) {
            $parents = $data['parents'];
        }

        $adapterFactory = new ConcreteProjectAdapterFactory(
            $data['code'],
            $converters,
            $databases,
            $types,
            $objects,
            $parents,
            $data['base_directory']
        );

        return $adapterFactory->create()->fromDataToProject($data);
    }

}
