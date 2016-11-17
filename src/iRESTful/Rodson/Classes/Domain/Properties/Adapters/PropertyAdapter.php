<?php
namespace iRESTful\Rodson\Classes\Domain\Properties\Adapters;

interface PropertyAdapter {
    public function fromNameToProperty($name);
}
