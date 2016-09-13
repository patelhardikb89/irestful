<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Factories\ConcreteProjectAdapterFactory;
use iRESTful\Rodson\Domain\Inputs\Projects\Exceptions\ProjectException;

final class ConcreteProjectAdapterVirgin implements ProjectAdapter {

    public function __construct() {

    }

    public function fromDataToProject(array $data) {
        if (!isset($data['code']) || !is_array($data['code'])) {
            throw new ProjectException('The code keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['converters']) || !is_array($data['converters'])) {
            throw new ProjectException('The converters keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['databases']) || !is_array($data['databases'])) {
            throw new ProjectException('The databases keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['types']) || !is_array($data['types'])) {
            throw new ProjectException('The types keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['objects']) || !is_array($data['objects'])) {
            throw new ProjectException('The objects keyname is mandatory in order to convert data to a Project object.');
        }

        if (!isset($data['base_directory']) || !is_string($data['base_directory'])) {
            throw new ProjectException('The base_directory keyname is mandatory in order to convert data to a Project object.');
        }

        $adapterFactory = new ConcreteProjectAdapterFactory(
            $data['code'],
            $data['converters'],
            $data['databases'],
            $data['types'],
            $data['objects'],
            $data['base_directory']
        );

        return $adapterFactory->create()->fromDataToProject($data);
    }

    public function fromDataToProjects(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToProject($oneData);
        }

        return $output;
    }

}
