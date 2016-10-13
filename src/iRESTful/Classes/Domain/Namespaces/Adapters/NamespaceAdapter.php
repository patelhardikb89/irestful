<?php
namespace iRESTful\Classes\Domain\Namespaces\Adapters;

interface NamespaceAdapter {
    public function fromDataToNamespace(array $data);
}
