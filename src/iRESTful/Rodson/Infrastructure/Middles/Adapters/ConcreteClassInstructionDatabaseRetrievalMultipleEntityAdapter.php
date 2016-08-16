<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\MultipleEntityAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Exception\MultipleEntityException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalMultipleEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;

final class ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapter implements MultipleEntityAdapter {
    private $keynameAdapter;
    private $valueAdapter;
    private $classes;
    public function __construct(KeynameAdapter $keynameAdapter, ValueAdapter $valueAdapter, array $classes) {
        $this->keynameAdapter = $keynameAdapter;
        $this->valueAdapter = $valueAdapter;
        $this->classes = $classes;
    }

    public function fromDataToMultipleEntity(array $data) {
        
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
            throw new MultipleEntityException('The object_name keyname is mandatory in order to convert data to a MultipleEntity object.');
        }

        if (!isset($data['property']) || !isset($data['property']['name'])) {
            throw new MultipleEntityException('The property->name keyname is mandatory in order to convert data to a MultipleEntity object.');
        }

        if (!isset($data['property']['value'])) {
            throw new MultipleEntityException('The property->value keyname is mandatory in order to convert data to a MultipleEntity object.');
        }


        $class = $getClassByObjectName($data['object_name']);
        if (empty($class)) {
            throw new MultipleEntityException('The given object_name ('.$data['object_name'].') does not reference any class.');
        }

        if ($data['property']['name'] == 'uuid') {
            $value = $this->valueAdapter->fromStringToValue($data['property']['name']);
            return new ConcreteClassInstructionDatabaseRetrievalMultipleEntity($class, $value);
        }

        $keyname = $this->keynameAdapter->fromDataToKeyname($data['property']);
        return new ConcreteClassInstructionDatabaseRetrievalMultipleEntity($class, null, $keyname);
    }

}
