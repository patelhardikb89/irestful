<?php
namespace iRESTful\DSLs\Domain\Projects\Converters;

interface Converter {
    public function hasFromType();
    public function fromType();
    public function hasToType();
    public function toType();
}
