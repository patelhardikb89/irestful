<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;
use iRESTful\Rodson\Domain\Outputs\Classes\ObjectClass;

interface CodeAdapter {
    public function fromInterfaceToCode(Interface $interface);
    public function fromClassToCode(ObjectClass $class);
}
