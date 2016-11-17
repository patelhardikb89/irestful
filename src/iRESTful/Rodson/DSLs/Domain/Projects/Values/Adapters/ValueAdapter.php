<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Values\Adapters;

interface ValueAdapter {
    public function fromDataToValues(array $data);
    public function fromStringToValue($string);
}
