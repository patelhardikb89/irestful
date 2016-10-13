<?php
namespace iRESTful\ClassesApplications\Domain\Adapters;
use iRESTful\ClassesConfigurations\Domain\Configuration;

interface ApplicationAdapter {
    public function fromConfigurationToApplication(Configuration $configuration);
}
