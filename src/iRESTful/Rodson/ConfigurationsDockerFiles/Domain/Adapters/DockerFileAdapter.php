<?php
namespace iRESTful\Rodson\ConfigurationsDockerFiles\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\DSL;

interface DockerFileAdapter {
    public function fromDSLToDockerFile(DSL $dsl);
}
