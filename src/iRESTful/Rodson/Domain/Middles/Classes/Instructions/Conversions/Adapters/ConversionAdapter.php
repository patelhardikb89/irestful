<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters;

interface ConversionAdapter {
    public function fromStringToConversion($string);
}
