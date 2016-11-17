<?php
namespace iRESTful\Rodson\ConfigurationsPHPUnits\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\DSL;

interface PHPUnitAdapter {
    public function fromDSLToPHPUnit(DSL $dsl);
}
