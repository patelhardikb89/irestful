<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces;

interface ObjectInterface {
    public function getName();
    public function getMethods();
    public function getNamespace();
}
