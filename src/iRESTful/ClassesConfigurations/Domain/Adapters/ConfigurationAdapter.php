<?php
namespace iRESTful\ClassesConfigurations\Domain\Adapters;

interface ConfigurationAdapter {
    public function fromDataToConfiguration(array $data);
}
