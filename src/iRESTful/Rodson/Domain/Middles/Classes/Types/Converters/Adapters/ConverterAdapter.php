<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Adapters;

interface ConverterAdapter {
    public function fromDataToConverter(array $data);
}
