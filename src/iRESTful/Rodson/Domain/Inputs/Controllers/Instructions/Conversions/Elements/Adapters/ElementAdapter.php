<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Conversions\Elements\Adapters;

interface ElementAdapter {
    public function fromStringToElement($string);
}
