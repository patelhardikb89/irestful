<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects;

interface Object {
    public function getName();
    public function getProperties();
    public function hasDatabase();
    public function getDatabase();
    public function hasMethods();
    public function getMethods();
    public function hasSamples();
    public function getSamples();
}
