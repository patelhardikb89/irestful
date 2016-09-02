<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Adapters;

interface FromAdapter {
    public function fromStringToFrom($string);
}
