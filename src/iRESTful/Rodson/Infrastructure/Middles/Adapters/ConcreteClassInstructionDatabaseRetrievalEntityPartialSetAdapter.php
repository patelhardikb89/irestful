<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\EntityPartialSetAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Exceptions\EntityPartialSetException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalEntityPartialSet;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter implements EntityPartialSetAdapter {
    private $valueAdapter;
    private $classes;
    public function __construct(ValueAdapter $valueAdapter, array $classes) {
        $this->valueAdapter = $valueAdapter;
        $this->classes = $classes;
    }

    public function fromDataToEntityPartialSet(array $data) {

        $classes = $this->classes;
        $getClassByObjectName = function($objectName) use(&$classes) {

            foreach($classes as $oneClass) {
                $input = $oneClass->getInput();
                if (!$input->hasObject()) {
                    continue;
                }

                $object = $input->getObject();
                if ($object->getName() == $objectName) {
                    return $oneClass;
                }
            }

            return null;

        };

        if (!isset($data['object_name'])) {
            throw new EntityPartialSetException('The object_name keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        if (!isset($data['minimum'])) {
            throw new EntityPartialSetException('The minimum keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        if (!isset($data['maximum'])) {
            throw new EntityPartialSetException('The maximum keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        $class = $getClassByObjectName($data['object_name']);
        $minimum = $this->valueAdapter->fromStringToValue($data['minimum']);
        $maximum = $this->valueAdapter->fromStringToValue($data['maximum']);
        return new ConcreteClassInstructionDatabaseRetrievalEntityPartialSet($class, $minimum, $maximum);
    }

}
