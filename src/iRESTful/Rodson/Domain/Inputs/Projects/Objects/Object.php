<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Objects;

interface Object {
    public function getName();
    public function getProperties();
    public function getTypes();
    public function hasSamples();
    public function getSamples();
    public function hasDatabase();
    public function getDatabase();
    public function hasMethods();
    public function getMethods();
}
