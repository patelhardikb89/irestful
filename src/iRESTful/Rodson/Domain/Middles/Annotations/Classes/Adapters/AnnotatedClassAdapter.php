<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Classes\Adapters;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface AnnotatedClassAdapter {
    public function fromRodsonToAnnotatedClasses(Rodson $rodson);
}
