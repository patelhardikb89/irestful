<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain\Objects\Adapters;

interface ObjectConfigurationAdapter {
    public function fromDataToObjectConfiguration(array $data);
}
