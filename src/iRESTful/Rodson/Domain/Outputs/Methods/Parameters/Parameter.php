<?php
namespace iRESTful\Rodson\Domain\Outputs\Methods\Parameters;

interface Parameter {
    public function getName();
    public function isParent();
    public function hasReturnedInterface();
    public function getReturnedInterface();
}
