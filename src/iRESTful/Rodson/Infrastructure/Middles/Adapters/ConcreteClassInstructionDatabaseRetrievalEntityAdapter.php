<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Exceptions\EntityException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityAdapter implements EntityAdapter {
    private $keynameAdapter;
    private $valueAdapter;
    private $classes;
    public function __construct(KeynameAdapter $keynameAdapter, ValueAdapter $valueAdapter, array $classes) {
        $this->keynameAdapter = $keynameAdapter;
        $this->valueAdapter = $valueAdapter;
        $this->classes = $classes;
    }

    public function fromDataToEntity(array $data) {

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
            throw new EntityException('The object_name keyname is mandatory in order to convert data to an Entity object.');
        }

        if (!isset($data['property']) || !isset($data['property']['name'])) {
            throw new EntityException('The property->name keyname is mandatory in order to convert data to an Entity object.');
        }

        if (!isset($data['property']['value'])) {
            throw new EntityException('The property->value keyname is mandatory in order to convert data to an Entity object.');
        }


        $class = $getClassByObjectName($data['object_name']);
        if (empty($class)) {
            throw new EntityException('The given object_name ('.$data['object_name'].') does not reference any class.');
        }

        if ($data['property']['name'] == 'uuid') {
            $value = $this->valueAdapter->fromStringToValue($data['property']['name']);
            return new ConcreteClassInstructionDatabaseRetrievalEntity($class, $value);
        }

        $keyname = $this->keynameAdapter->fromDataToKeyname($data['property']);
        return new ConcreteClassInstructionDatabaseRetrievalEntity($class, null, $keyname);


    }

}
