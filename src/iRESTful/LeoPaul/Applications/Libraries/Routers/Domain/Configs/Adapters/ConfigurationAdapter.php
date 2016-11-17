<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Adapters;

interface ConfigurationAdapter {
    public function fromDataToConfiguration(array $data);
}
