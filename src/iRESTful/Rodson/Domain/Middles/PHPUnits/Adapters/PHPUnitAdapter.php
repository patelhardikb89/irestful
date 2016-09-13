<?php
namespace iRESTful\Rodson\Domain\Middles\PHPUnits\Adapters;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface PHPUnitAdapter {
    public function fromRodsonToPHPUnit(Rodson $rodson);
}
