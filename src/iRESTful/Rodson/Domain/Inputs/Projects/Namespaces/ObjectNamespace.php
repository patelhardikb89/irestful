<?php
namespace iRESTful\Rodson\Domain\Middles\Namespaces;

interface ObjectNamespace {
    public function isMandatory();
    public function get();
}
