<?php
namespace iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\Adapters;

interface NamespaceAdapterAdapter {
    public function fromBaseNamespaceToNamespaceAdapter(array $baseNamespace);
}
