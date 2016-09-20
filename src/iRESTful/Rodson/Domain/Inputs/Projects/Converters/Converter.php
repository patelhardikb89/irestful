<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Converters;

interface Converter {
    public function hasFromType();
    public function fromType();
    public function hasToType();
    public function toType();
}
