<?php
namespace iRESTful\Authenticated\Domain\Objects;


interface ParamPattern {
    public function getRegex_pattern();
    public function getSpecific_value();
}

