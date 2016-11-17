<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects;

interface Project {
    public function getTypes();
    public function getRelationalDatabase();
    public function hasObjects();
    public function getObjects();
    public function hasEntities();
    public function getEntities();
    public function hasEntityByName(string $name);
    public function getEntityByName(string $name);
    public function hasControllers();
    public function getControllers();
    public function hasParents();
    public function getParents();
}
