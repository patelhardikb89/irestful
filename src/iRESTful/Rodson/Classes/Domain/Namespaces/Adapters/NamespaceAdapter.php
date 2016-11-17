<?php
namespace iRESTful\Rodson\Classes\Domain\Namespaces\Adapters;

interface NamespaceAdapter {
    public function fromDataToNamespace(array $data);
    public function fromFullDataToNamespace(array $data);
}
