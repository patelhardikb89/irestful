<?php
namespace iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\Adapters;

interface NamespaceAdapterAdapter {
    public function fromBaseNamespaceToNamespaceAdapter(array $baseNamespace);
}
