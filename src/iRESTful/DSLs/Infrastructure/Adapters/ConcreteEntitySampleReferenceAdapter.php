<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\References\Adapters\ReferenceAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteEntitySampleReference;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\References\Exceptions\ReferenceException;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;

final class ConcreteEntitySampleReferenceAdapter implements ReferenceAdapter {

    public function __construct() {

    }

    public function fromDataToReferences(array $data) {

        $getSampleFromProperty = function(Property $property) use(&$data) {

            $type = $property->getType();
            if ($type->hasObject()) {
                $name = $type->getObject()->getName();
                if (!isset($data['samples'][$name])) {
                    throw new ReferenceException('The given object ('.$name.') does not have samples.');
                }

                return $data['samples'][$name];
            }

            if ($type->hasParentObject()) {
                $parentObject = $type->getParentObject();
                $objectName = $parentObject->getObject()->getName();
                $project = $parentObject->getSubDSL()->getDSL()->getProject();
                if ($project->hasEntityByName($objectName)) {
                    return $project->getEntityByName($objectName)->getSample();
                }

                throw new ReferenceException('The given parent object ('.$objectName.') does not refer to an Entity, therefore cannot have samples.');
            }

            $propertyName = $property->getName();
            throw new ReferenceException('The given property ('.$propertyName.')is not an Object or a ParentObject.  Therefore, it is not a reference.');
        };

        if (!isset($data['samples'])) {
            throw new ReferenceException('The samples keyname is mandatory in order to convert data to Reference objects.');
        }

        if (!isset($data['properties'])) {
            throw new ReferenceException('The properties keyname is mandatory in order to convert data to Reference objects.');
        }

        $references = [];
        foreach($data['properties'] as $oneProperty) {
            $sample = $getSampleFromProperty($oneProperty);
            $references[] = new ConcreteEntitySampleReference($sample, $oneProperty);
        }

        return $references;
    }

}
