<?php
namespace iRESTful\Rodson\Domain\Middles\Classes;

interface ObjectClass {
    public function getName();
    public function getInput();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
    public function hasCustomMethods();
    public function getCustomMethods();
    public function hasAssignment();
    public function getAssignment();
    public function hasSubClasses();
    public function getSubClasses();
}
