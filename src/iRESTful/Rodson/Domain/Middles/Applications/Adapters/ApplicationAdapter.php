<?php
namespace iRESTful\Rodson\Domain\Middles\Applications\Adapters;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;

interface ApplicationAdapter {
    public function fromConfigurationToApplication(Configuration $configuration);
}
