<?php
namespace iRESTful\Rodson\Domain\Inputs\Values\Adapters;

interface ValueAdapter {
    public function fromDataToValues(array $data);
    public function fromStringToValue($string);
}
