<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters;

interface Parameter {
    public function getProperty();
    public function getParameter();
    public function hasMethod();
    public function getMethod();
    public function getData();
}
