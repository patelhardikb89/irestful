<?php
namespace iRESTful\Classes\Domain\Constructors\Parameters;

interface Parameter {
    public function getProperty();
    public function getParameter();
    public function hasMethod();
    public function getMethod();
}
