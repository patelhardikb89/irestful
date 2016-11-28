<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Adapters;

interface PropertyAdapter {
    public function fromDataToProperty(array $data);
}
