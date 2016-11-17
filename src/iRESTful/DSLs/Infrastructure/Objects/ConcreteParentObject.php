<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\ParentObject;
use iRESTful\DSLs\Domain\SubDSLs\SubDSL;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\Exceptions\ParentObjectException;

final class ConcreteParentObject implements ParentObject {
    private $subDSL;
    private $object;
    public function __construct(SubDSL $subDSL, Object $object) {

        if (!$object->hasDatabase()) {
            $dslName = $subDSL->getName();
            $name = $object->getName();
            throw new ParentObjectException('The parent object ('.$dslName.'->'.$name.') cannot be referenced because it does not have a database.');
        }

        $this->subDSL = $subDSL;
        $this->object = $object;
    }

    public function getSubDSL() {
        return $this->subDSL;
    }

    public function getObject() {
        return $this->object;
    }

}
