<?php
namespace iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\Adapters;

interface NamespaceAdapterAdapter {
    public function fromBaseNamespaceToNamespaceAdapter(array $baseNamespace);
}
