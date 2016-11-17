<?php
namespace iRESTful\Rodson\ClassesConverters\Domain;

interface Converter {
    public function getType();
    public function getInterface();
    public function getNamespace();
    public function getConstructor();
    public function getMethods();
}
