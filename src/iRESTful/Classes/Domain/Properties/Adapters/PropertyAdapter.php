<?php
namespace iRESTful\Classes\Domain\Properties\Adapters;

interface PropertyAdapter {
    public function fromNameToProperty($name);
}
