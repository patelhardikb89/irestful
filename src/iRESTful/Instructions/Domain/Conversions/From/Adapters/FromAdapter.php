<?php
namespace iRESTful\Instructions\Domain\Conversions\From\Adapters;

interface FromAdapter {
    public function fromStringToFrom($string);
}
