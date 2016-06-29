<?php
namespace iRESTful\Rodson\Domain\Codes\Methods\Adapters;

interface MethodAdapter {
    public function fromStringToMethod($string);
}
