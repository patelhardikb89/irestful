<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Nodes;

interface ControllerNode {
    public function getControllers();
    public function hasNamespaces();
    public function getNamespaces();
    public function hasParameters();
    public function getParameters();
    public function getData();
}
