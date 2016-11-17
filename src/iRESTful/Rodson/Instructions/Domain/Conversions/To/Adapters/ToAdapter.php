<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\To\Adapters;

interface ToAdapter {
    public function fromStringToTo($string);
}
