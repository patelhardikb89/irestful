<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects;

interface Object {
    public function getName();
    public function getProperties();
    public function hasDatabase();
    public function getDatabase();
    public function hasCombos();
    public function getCombos();
    public function hasConverters();
    public function getConverters();
    public function getPropertyTypes();
    public function getTypes();
    public function getObjectByPropertyByName(string $name);
}
