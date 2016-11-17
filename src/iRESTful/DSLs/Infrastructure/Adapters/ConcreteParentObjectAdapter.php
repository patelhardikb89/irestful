<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\Adapters\ParentObjectAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteParentObject;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\Exceptions\ParentObjectException;

final class ConcreteParentObjectAdapter implements ParentObjectAdapter {

    public function __construct() {

    }

    public function fromDataToParentObject(array $data) {

        if (!isset($data['sub_dsl'])) {
            throw new ParentObjectException('The sub_dsl keyname is mandatory in order to convert data to a ParentObject.');
        }

        if (!isset($data['name'])) {
            throw new ParentObjectException('The object keyname is mandatory in order to convert data to a ParentObject.');
        }

        $project = $data['sub_dsl']->getDSL()->getProject();
        if (!$project->hasObjects()) {
            throw new ParentObjectException('The parent object ('.$data['name'].') could not be found because the SubDSL does not have any object.');
        }

        $objects =$project->getObjects();
        if (!isset($objects[$data['name']])) {
            throw new ParentObjectException('The parent object ('.$data['name'].') could not be found in the SubDSL.');
        }

         return new ConcreteParentObject($data['sub_dsl'], $objects[$data['name']]);

    }

}
