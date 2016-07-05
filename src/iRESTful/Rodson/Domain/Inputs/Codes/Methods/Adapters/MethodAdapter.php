<?php
namespace iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters;

interface MethodAdapter {
    public function fromStringToMethod($string);
}
