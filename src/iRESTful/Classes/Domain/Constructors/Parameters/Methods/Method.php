<?php
namespace iRESTful\Classes\Domain\Constructors\Parameters\Methods;

interface Method {
    public function getName();
    public function hasSubMethod();
    public function getSubMethod();
}
