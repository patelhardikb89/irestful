<?php
namespace iRESTful\Rodson\Domain\Middles\Namespaces;

interface ClassNamespace {
    public function getName();
    public function getPath();
    public function getAll();
    public function getAllAsString();
    public function getPathAsString();
    public function getData();
}
