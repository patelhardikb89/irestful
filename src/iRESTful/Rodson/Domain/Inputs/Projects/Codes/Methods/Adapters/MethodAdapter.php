<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Adapters;

interface MethodAdapter {
    public function fromStringToMethod($string);
}
