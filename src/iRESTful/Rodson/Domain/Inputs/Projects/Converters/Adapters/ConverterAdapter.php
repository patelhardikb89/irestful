<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Converters\Adapters;

interface ConverterAdapter {
    public function fromDataToConverters(array $data);
    public function fromDataToConverter(array $data);
}
