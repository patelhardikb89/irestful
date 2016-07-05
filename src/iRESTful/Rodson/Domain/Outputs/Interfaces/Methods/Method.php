<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Methods;

interface Method {
    public function getName();
    public function hasReturnedType();
    public function getReturnedType();
    public function hasParameters();
    public function getParameters();
}
