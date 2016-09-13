<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects;

interface Project {
    public function getObjects();
    public function getControllers();
    public function hasParents();
    public function getParents();
}
