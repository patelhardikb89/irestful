<?php
namespace iRESTful\Rodson\ClassesEntities\Domain;

interface Entity {
    public function getEntity();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
}
