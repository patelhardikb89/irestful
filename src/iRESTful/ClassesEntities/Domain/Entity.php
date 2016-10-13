<?php
namespace iRESTful\ClassesEntities\Domain;

interface Entity {
    public function getObject();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
    public function hasCustomMethods();
    public function getCustomMethods();
}
