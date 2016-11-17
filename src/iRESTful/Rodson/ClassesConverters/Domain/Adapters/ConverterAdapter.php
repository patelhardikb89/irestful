<?php
namespace iRESTful\Rodson\ClassesConverters\Domain\Adapters;

interface ConverterAdapter {
    public function fromDataToConverter(array $data);
}
