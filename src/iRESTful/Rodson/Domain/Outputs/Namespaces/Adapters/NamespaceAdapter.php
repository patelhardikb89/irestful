<?php
namespace iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters;

interface NamespaceAdapter {
    public function fromStringToNamespace($string);
    public function fromDataToNamespace(array $data);
}
