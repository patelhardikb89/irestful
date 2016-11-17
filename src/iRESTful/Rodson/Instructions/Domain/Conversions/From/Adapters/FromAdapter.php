<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\From\Adapters;

interface FromAdapter {
    public function fromStringToFrom($string);
}
