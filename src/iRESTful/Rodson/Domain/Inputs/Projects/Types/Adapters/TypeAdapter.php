<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Adapters;

interface TypeAdapter {
    public function fromDataToValidTypes(array $data);
    public function fromDataToTypes(array $data);
    public function fromDataToType(array $data);
}