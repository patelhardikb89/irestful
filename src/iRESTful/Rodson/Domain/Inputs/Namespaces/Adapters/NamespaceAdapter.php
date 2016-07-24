<?php
namespace iRESTful\Rodson\Domain\Middles\Namespaces\Adapters;

interface NamespaceAdapter {
    public function fromStringToNamespace($string);
    public function fromDataToNamespace(array $data);
}
