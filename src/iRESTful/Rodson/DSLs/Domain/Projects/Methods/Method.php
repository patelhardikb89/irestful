<?php
namespace iRESTful\Rodson\Rodson\Domain\Outputs\Methods;

interface Method {
    public function getName();
    public function hasReturnedType();
    public function getReturnedType();
    public function hasParameters();
    public function getParameters();
}
