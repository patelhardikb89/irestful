<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;

interface CodeAdapter {
    public function fromClassToCodes(ObjectClass $classes);
    public function fromClassesToCodes(array $classes);
}
