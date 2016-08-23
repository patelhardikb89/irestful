<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces;

interface ClassInterface {
    public function getMethods();
    public function getNamespace();
    public function isEntity();
    public function getData();
}
