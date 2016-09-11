<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Adapters;

interface ConfigurationAdapter {
    public function fromDataToConfiguration(array $data);
}
