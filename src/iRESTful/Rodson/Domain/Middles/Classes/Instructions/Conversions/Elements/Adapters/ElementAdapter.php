<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Adapters;

interface ElementAdapter {
    public function fromStringToElement($string);
}
