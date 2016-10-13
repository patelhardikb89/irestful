<?php
namespace iRESTful\DSLs\Domain\Projects;

interface Project {
    public function getObjects();
    public function getControllers();
    public function getTypes();
    public function getRelationalDatabase();
    public function hasParents();
    public function getParents();
}
