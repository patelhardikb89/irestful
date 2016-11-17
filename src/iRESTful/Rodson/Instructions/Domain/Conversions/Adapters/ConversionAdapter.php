<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\Adapters;

interface ConversionAdapter {
    public function fromStringToConversion($string);
}
