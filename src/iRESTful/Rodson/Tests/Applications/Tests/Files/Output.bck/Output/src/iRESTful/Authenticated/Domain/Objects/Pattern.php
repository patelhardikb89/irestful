<?php
namespace iRESTful\Authenticated\Domain\Objects;


interface Pattern {
    public function getRegex_pattern();
    public function getSpecific_uri();
}

