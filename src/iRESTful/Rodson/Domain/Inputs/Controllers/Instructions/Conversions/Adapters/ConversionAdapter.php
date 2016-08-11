<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Conversions\Adapters;

interface ConversionAdapter {
    public function fromStringToConversion($string);
}
