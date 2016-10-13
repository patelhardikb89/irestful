<?php
namespace iRESTful\ClassesConverters\Domain\Adapters;

interface ConverterAdapter {
    public function fromDataToConverter(array $data);
}
