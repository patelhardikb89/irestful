<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Objects;

interface Object {
    public function getObject();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
    public function hasCustomMethods();
    public function getCustomMethods();
    public function getData();
}
