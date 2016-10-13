<?php
namespace iRESTful\Instructions\Domain\Conversions\Adapters\Adapters;

interface ConversionAdapterAdapter {
    public function fromDataToConversionAdapter(array $data);
}
