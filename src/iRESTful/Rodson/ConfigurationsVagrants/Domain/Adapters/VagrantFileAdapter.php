<?php
namespace iRESTful\Rodson\ConfigurationsVagrants\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\DSL;

interface VagrantFileAdapter {
    public function fromDSLToVagrantFile(DSL $dsl);
}
