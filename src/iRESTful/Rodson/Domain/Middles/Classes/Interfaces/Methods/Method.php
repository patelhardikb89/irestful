<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods;

interface Method {
    public function getName();
    public function hasParameters();
    public function getParameters();
}
