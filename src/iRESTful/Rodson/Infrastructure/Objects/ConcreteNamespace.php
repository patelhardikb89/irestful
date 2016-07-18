<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Exceptions\NamespaceException;

final class ConcreteNamespace implements ObjectNamespace {
    private $namespace;
    private $isMandatory;
    public function __construct(array $namespace, $isMandatory) {

        if (empty($namespace)) {
            throw new NamespaceException('The namespace array cannot be empty.');
        }

        foreach($namespace as $onePart) {
            if (empty($onePart) || !is_string($onePart)) {
                throw new NamespaceException('The namespace array must only contain non-empty string elements.');
            }
        }

        $this->namespace = $namespace;
        $this->isMandatory = $isMandatory;
    }

    public function isMandatory() {
        return $this->isMandatory;
    }

    public function get() {
        return $this->namespace;
    }

}
