<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Objects\Adapters;

interface ObjectAdapter {
    public function fromDataToValidObjects(array $data);
    public function fromDataToObjects(array $data);
    public function fromDataToObject(array $data);
}