<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Properties\Adapters;

interface PropertyAdapter {
    public function fromDataToProperties(array $data);
    public function fromDataToProperty(array $data);
}
