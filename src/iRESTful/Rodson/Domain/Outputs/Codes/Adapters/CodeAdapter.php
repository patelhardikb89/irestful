<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\ObjectInterface;
use iRESTful\Rodson\Domain\Outputs\Classes\ObjectClass;

interface CodeAdapter {
    public function fromInterfaceToCode(ObjectInterface $interface);
    public function fromClassToCode(ObjectClass $class);
    public function fromClassesToCodes(array $classes);
}
