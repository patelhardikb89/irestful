<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Namespaces\Adapters\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;

interface NamespaceAdapterAdapter {
    public function fromRootInterfaceToNamespaceAdapter(Interface $rootInterface);
}
