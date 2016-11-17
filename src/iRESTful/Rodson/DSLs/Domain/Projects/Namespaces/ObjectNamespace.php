<?php
namespace iRESTful\Rodson\Classes\Domain\Namespaces;

interface ObjectNamespace {
    public function isMandatory();
    public function get();
}
