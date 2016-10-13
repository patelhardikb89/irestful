<?php
namespace iRESTful\Classes\Domain\Namespaces\Adapters;

interface NamespaceAdapter {
    public function fromStringToNamespace($string);
    public function fromDataToNamespace(array $data);
}
