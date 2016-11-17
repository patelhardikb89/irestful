<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters;

interface Parameter {
    public function getName();
    public function getType();
    public function isOptional();
}
