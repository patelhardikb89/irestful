<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Adapters\Adapters\InterfaceAdapterAdapter;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\Adapters\NamespaceAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;

final class ConcreteInterfaceAdapterAdapter implements InterfaceAdapterAdapter {
    private $methodAdapter;
    private $namespaceAdapterAdapter;
    public function __construct(MethodAdapter $methodAdapter, NamespaceAdapterAdapter $namespaceAdapterAdapter) {
        $this->methodAdapter = $methodAdapter;
        $this->namespaceAdapterAdapter = $namespaceAdapterAdapter;
    }

    public function fromBaseNamespaceToInterfaceAdapter(array $baseNamespace) {
        $namespaceAdapter = $this->namespaceAdapterAdapter->fromBaseNamespaceToNamespaceAdapter($baseNamespace);
        return new ConcreteInterfaceAdapter($this->methodAdapter, $namespaceAdapter);
    }

}
