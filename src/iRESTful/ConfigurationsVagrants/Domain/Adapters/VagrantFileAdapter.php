<?php
namespace iRESTful\ConfigurationsVagrants\Domain\Adapters;
use iRESTful\DSLs\Domain\DSL;

interface VagrantFileAdapter {
    public function fromDSLToVagrantFile(DSL $dsl);
}
