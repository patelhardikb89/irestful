<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\Adapters\Adapters;

interface ConversionAdapterAdapter {
    public function fromDataToConversionAdapter(array $data);
}
