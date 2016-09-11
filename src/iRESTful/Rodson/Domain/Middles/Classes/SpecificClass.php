<?php
namespace iRESTful\Rodson\Domain\Middles\Classes;

interface SpecificClass {
    public function hasAnnotatedObject();
    public function getAnnotatedObject();
    public function hasAnnotatedEntity();
    public function getAnnotatedEntity();
    public function hasValue();
    public function getValue();
    public function hasController();
    public function getController();
    public function hasTest();
    public function getTest();
    public function getNamespace();
}
