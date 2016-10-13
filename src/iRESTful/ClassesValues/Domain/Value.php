<?php
namespace iRESTful\ClassesValues\Domain;

interface Value {
    public function getType();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
    public function getConverter();
    public function hasCustomMethod();
    public function getCustomMethod();
}
