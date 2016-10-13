<?php
namespace iRESTful\Classes\Domain\Namespaces\Adapters\Adapters;

interface NamespaceAdapterAdapter {
    public function fromBaseNamespaceToNamespaceAdapter(array $baseNamespace);
}
