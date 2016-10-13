<?php
namespace iRESTful\ConfigurationsPHPUnits\Domain\Adapters;
use iRESTful\DSLs\Domain\DSL;

interface PHPUnitAdapter {
    public function fromDSLToPHPUnit(DSL $dsl);
}
