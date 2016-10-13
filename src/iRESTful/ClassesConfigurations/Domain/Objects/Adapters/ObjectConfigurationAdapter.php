<?php
namespace iRESTful\ClassesConfigurations\Domain\Objects\Adapters;

interface ObjectConfigurationAdapter {
    public function fromDataToObjectConfiguration(array $data);
}
