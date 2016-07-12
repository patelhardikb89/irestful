<?php
namespace iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters;

interface NamespaceAdapter {
    public function fromDataToNamespace(array $data);
}
