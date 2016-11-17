<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain\Adapters;

interface ConfigurationAdapter {
    public function fromDataToConfiguration(array $data);
}
