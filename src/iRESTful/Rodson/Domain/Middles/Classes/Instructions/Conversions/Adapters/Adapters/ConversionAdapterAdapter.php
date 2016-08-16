<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\Adapters;

interface ConversionAdapterAdapter {
    public function fromDataToConversionAdapter(array $data);
}
