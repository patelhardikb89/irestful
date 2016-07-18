<?php
namespace iRESTful\Rodson\Domain\Outputs\Classes;

interface ObjectClass {
    public function getName();
    public function getNamespace();
    public function getProperties();
    public function getInterface();
    public function getConstructor();
    public function getMethods();
    public function isEntity();
    public function hasSubClasses();
    public function getSubClasses();
}
