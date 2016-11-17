<?php
namespace iRESTful\Rodson\Instructions\Domain\Values\Adapters;

interface ValueAdapter {
    public function fromDataToValues(array $data);
    public function fromStringToValue($string);
}
