<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface InterfaceAdapter {
    public function fromObjectToInterface(Object $object);
    public function fromTypeToInterface(Type $type);
    public function fromTypeToAdapterInterface(Type $type);
}
