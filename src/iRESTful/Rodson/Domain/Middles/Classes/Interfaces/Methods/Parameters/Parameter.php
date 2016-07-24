<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters;

interface Parameter {
    public function getName();
    public function getType();
    public function isOptional();
}
