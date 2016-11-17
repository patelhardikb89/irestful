<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces;

interface ClassInterface {
    public function getName();
    public function getMethods();
    public function getNamespace();
    public function isEntity();
}
