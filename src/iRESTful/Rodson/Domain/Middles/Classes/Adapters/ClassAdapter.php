<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Adapters;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface ClassAdapter {
    public function fromRodsonToClasses(Rodson $rodson);
}
