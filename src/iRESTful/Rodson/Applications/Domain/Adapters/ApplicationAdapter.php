<?php
namespace iRESTful\Rodson\Applications\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\DSL;

interface ApplicationAdapter {
    public function fromDSLToApplication(DSL $dsl);
}
