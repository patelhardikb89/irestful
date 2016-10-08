<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Adapters;

interface ValueAdapter {
    public function fromDataToValues(array $data);
    public function fromStringToValue($string);
}
