<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects\Properties;

interface Property {
    public function getName();
    public function getType();
    public function isOptional();
}
