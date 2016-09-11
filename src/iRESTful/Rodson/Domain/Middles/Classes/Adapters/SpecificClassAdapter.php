<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Adapters;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface SpecificClassAdapter {
    public function fromRodsonToClasses(Rodson $rodson);
}
