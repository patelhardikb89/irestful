<?php
namespace iRESTful\Rodson\Domain;

interface Rodson {
    public function getName();
    public function getEntities();
    public function getControllers();
    public function hasParents();
    public function getParents();
}
