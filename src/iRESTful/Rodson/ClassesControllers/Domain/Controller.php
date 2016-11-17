<?php
namespace iRESTful\Rodson\ClassesControllers\Domain;

interface Controller {
    public function getNamespace();
    public function getConstructor();
    public function getCustomMethod();
}
