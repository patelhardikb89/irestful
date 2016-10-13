<?php
namespace iRESTful\Instructions\Domain\Conversions\To\Adapters;

interface ToAdapter {
    public function fromStringToTo($string);
}
