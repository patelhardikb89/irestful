<?php
namespace iRESTful\Rodson\ClassesApplications\Domain\Adapters;
use iRESTful\Rodson\ClassesConfigurations\Domain\Configuration;

interface ApplicationAdapter {
    public function fromConfigurationToApplication(Configuration $configuration);
}
