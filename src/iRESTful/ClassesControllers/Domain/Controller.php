<?php
namespace iRESTful\ClassesControllers\Domain;

interface Controller {
    public function getNamespace();
    public function getConstructor();
    public function getCustomMethod();
    public function getTestClass();
}
