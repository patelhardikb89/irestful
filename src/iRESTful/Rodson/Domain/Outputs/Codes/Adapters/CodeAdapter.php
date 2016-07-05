<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;

interface CodeAdapter {
    public function fromInterfaceToCode(Interface $interface);
}
