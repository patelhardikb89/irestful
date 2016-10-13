<?php
namespace iRESTful\Classes\Domain\Namespaces;

interface ObjectNamespace {
    public function isMandatory();
    public function get();
}
