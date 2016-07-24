<?php
namespace iRESTful\Rodson\Domain\Middles\Classes;

interface ObjectClass {
    public function getName();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
    public function hasGetterMethods();
    public function getGetterMethods();
    public function hasCustomMethods();
    public function getCustomMethods();
    public function hasSubClasses();
    public function getSubClasses();
}
