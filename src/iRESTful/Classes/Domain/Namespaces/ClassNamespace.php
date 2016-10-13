<?php
namespace iRESTful\Classes\Domain\Namespaces;

interface ClassNamespace {
    public function getName();
    public function getPath();
    public function getAll();
    public function getAllAsString();
    public function getPathAsString();
}
