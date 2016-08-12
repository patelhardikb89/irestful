<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\MultipleEntity;
use iRESTful\Rodson\Domain\Inputs\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Keyname;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Exceptions\MultipleEntityException;

final class ConcreteClassInstructionDatabaseRetrievalMultipleEntity implements MultipleEntity {
    private $class;
    private $uuidValues;
    private $keynames;
    public function __construct(ObjectClass $class, array $uuidValues = null, array $keynames = null) {

        if (empty($uuidValues)) {
            $uuidValues = null;
        }

        if (empty($keynames)) {
            $keynames = null;
        }

        $amount = (empty($uuidValues) ? 0 : 1) + (empty($keynames) ? 0 : 1);
        if ($amount != 1) {
            throw new MultipleEntityException('One of these must be non-empty: uuidValues, keynames.  '.$amount.' given.');
        }

        if (!empty($uuidValues)) {
            foreach($uuidValues as $oneUuidValue) {
                if (!($oneUuidValue instanceof Value)) {
                    throw new MultipleEntityException('The uuidValues array must contain Value objects if non-empty.');
                }
            }
        }

        if (!empty($keynames)) {
            foreach($keynames as $oneKeyname) {
                if (!($oneKeyname instanceof Keyname)) {
                    throw new MultipleEntityException('The keynames array must contain Keyname objects if non-empty.');
                }
            }
        }

        $this->class = $class;
        $this->uuidValues = $uuidValues;
        $this->keynames = $keynames;

    }

    public function getClass() {
        return $this->class;
    }

    public function hasUuidValues() {
        return !empty($this->uuidValues);
    }

    public function getUuidValues() {
        return $this->uuidValues;
    }

    public function hasKeynames() {
        return !empty($this->keynames);
    }

    public function getKeynames() {
        return $this->keynames;
    }

}
