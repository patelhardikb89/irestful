<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects\Properties\Adapters;

interface PropertyAdapter {
    public function fromDataToProperties(array $data);
    public function fromDataToProperty(array $data);
}
