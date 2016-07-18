<?php
namespace iRESTful\Rodson\Domain\Outputs\Namespaces;

interface ObjectNamespace {
    public function isMandatory();
    public function get();
}
