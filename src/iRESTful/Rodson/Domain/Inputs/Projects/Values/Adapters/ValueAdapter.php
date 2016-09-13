<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters;

interface ValueAdapter {
    public function fromDataToValues(array $data);
    public function fromStringToValue($string);
}
