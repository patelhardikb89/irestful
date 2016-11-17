<?php
namespace iRESTful\Rodson\Rodson\Domain\Outputs\Methods\Parameters;

interface Parameter {
    public function getName();
    public function isParent();
    public function isArray();
    public function hasReturnedInterface();
    public function getReturnedInterface();
}
