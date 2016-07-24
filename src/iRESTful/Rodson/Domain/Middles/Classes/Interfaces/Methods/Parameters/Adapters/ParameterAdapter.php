<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters;

interface ParameterAdapter {
    public function fromDataToParameter(array $data);
}
