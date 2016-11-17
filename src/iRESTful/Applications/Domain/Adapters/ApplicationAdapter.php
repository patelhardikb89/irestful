<?php
namespace iRESTful\Applications\Domain\Adapters;
use iRESTful\DSLs\Domain\DSL;

interface ApplicationAdapter {
    public function fromDSLToApplication(DSL $dsl);
}
