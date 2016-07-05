<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Namespaces\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;

interface NamespaceAdapter {
    public function fromInterfaceToNamespace(Interface $interface);
}
