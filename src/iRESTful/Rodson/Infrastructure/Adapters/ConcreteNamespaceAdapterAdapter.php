<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\Adapters\NamespaceAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteNamespaceAdapter;

final class ConcreteNamespaceAdapterAdapter implements NamespaceAdapterAdapter {

    public function __construct() {

    }

    public function fromBaseNamespaceToNamespaceAdapter(array $baseNamespace) {
        return new ConcreteNamespaceAdapter($baseNamespace);
    }

}
