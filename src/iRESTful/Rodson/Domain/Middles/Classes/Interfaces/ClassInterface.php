<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces;

interface ClassInterface {
    public function getName();
    public function getMethods();
    public function getNamespace();
    public function isEntity();
}
