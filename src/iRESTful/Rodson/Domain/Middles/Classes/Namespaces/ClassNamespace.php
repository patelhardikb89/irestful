<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Namespaces;

interface ClassNamespace {
    public function getName();
    public function getPath();
    public function getAll();
}
