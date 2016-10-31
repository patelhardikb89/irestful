<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Parameters;

interface Parameter {
    public function getConstructorParameter();
    public function hasClassNamespace();
    public function getClassNamespace();
}
