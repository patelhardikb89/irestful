<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces;

interface Interface {
    public function getName();
    public function getMethods();
    public function hasSubInterfaces();
    public function getSubInterfaces();
    public function hasAttachedInterfaces();
    public function getAttachedInterfaces();
}
