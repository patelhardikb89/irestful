<?php
namespace iRESTful\Classes\Domain\Interfaces\Methods;

interface Method {
    public function getName();
    public function hasParameters();
    public function getParameters();
}
