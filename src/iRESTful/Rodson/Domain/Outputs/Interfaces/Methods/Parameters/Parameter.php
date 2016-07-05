<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters;

interface Parameter {
    public function getName();
    public function hasInterface();
    public function getInterface();
}
