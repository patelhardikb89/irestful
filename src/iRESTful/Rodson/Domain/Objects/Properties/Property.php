<?php
namespace iRESTful\Rodson\Domain\Objects\Properties;

interface Property {
    public function getName();
    public function getType();
    public function isOptional();
}
