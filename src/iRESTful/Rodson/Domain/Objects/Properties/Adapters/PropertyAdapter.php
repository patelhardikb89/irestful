<?php
namespace iRESTful\Rodson\Domain\Objects\Properties\Adapters;

interface PropertyAdapter {
    public function fromDataToProperties(array $data);
    public function fromDataToProperty(array $data);
}
