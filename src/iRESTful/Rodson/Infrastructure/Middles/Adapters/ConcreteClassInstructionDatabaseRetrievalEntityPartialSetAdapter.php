<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\EntityPartialSetAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Exceptions\EntityPartialSetException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalEntityPartialSet;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter implements EntityPartialSetAdapter {
    private $valueAdapter;
    private $annotatedClasses;
    public function __construct(ValueAdapter $valueAdapter, array $annotatedClasses) {
        $this->valueAdapter = $valueAdapter;
        $this->annotatedClasses = $annotatedClasses;
    }

    public function fromDataToEntityPartialSet(array $data) {

        $annotatedClasses = $this->annotatedClasses;
        $getAnnotatedClassByObjectName = function($objectName) use(&$annotatedClasses) {

            foreach($annotatedClasses as $oneAnnotatedClass) {
                $oneClass = $oneAnnotatedClass->getClass();
                $input = $oneClass->getInput();
                if (!$input->hasObject()) {
                    continue;
                }

                $object = $input->getObject();
                if ($object->getName() == $objectName) {
                    return $oneAnnotatedClass;
                }
            }

            return null;

        };

        if (!isset($data['object_name'])) {
            throw new EntityPartialSetException('The object_name keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        if (!isset($data['index'])) {
            throw new EntityPartialSetException('The index keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        if (!isset($data['amount'])) {
            throw new EntityPartialSetException('The amount keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        $annotatedClass = $getAnnotatedClassByObjectName($data['object_name']);
        $index = $this->valueAdapter->fromStringToValue($data['index']);
        $amount = $this->valueAdapter->fromStringToValue($data['amount']);
        return new ConcreteClassInstructionDatabaseRetrievalEntityPartialSet($annotatedClass, $index, $amount);
    }

}
