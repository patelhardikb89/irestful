<?php
namespace iRESTful\Instructions\Domain\Conversions\Adapters;

interface ConversionAdapter {
    public function fromStringToConversion($string);
}
