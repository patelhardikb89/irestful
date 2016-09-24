<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Objects\Adapters;

interface ObjectConfigurationAdapter {
    public function fromDataToObjectConfiguration(array $data);
}
