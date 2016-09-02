<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters;

interface ToAdapter {
    public function fromStringToTo($string);
}
