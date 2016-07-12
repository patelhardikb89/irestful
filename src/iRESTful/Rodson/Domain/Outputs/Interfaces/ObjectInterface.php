<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces;

interface ObjectInterface {
    public function getName();
    public function getMethods();
    public function getNamespace();
    public function hasSubInterfaces();
    public function getSubInterfaces();
}
