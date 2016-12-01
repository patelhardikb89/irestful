<?php
namespace iRESTful\Rodson\ClassesConverters\Domain;

interface Converter {
    public function hasType();
    public function getType();
    public function hasObject();
    public function getObject();
    public function getInterface();
    public function getNamespace();
    public function getConstructor();
    public function hasMethods();
    public function getMethods();
    public function hasCustomMethods() ;
    public function getCustomMethods();
}
