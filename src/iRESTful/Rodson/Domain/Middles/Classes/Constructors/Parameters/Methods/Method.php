<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Methods;

interface Method {
    public function getName();
    public function hasSubMethod();
    public function getSubMethod();
}
