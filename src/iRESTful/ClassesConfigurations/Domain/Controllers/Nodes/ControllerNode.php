<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers\Nodes;

interface ControllerNode {
    public function getControllers();
    public function hasNamespaces();
    public function getNamespaces();
    public function hasParameters();
    public function getParameters();
}
