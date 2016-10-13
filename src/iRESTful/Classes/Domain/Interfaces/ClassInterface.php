<?php
namespace iRESTful\Classes\Domain\Interfaces;

interface ClassInterface {
    public function getMethods();
    public function getNamespace();
    public function isEntity();
}
