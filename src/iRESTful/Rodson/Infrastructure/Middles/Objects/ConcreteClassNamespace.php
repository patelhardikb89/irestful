<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Exceptions\NamespaceException;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\ClassNamespace;

final class ConcreteClassNamespace implements ClassNamespace {
    private $namespace;
    public function __construct(array $namespace) {

        if (empty($namespace)) {
            throw new NamespaceException('The namespace array cannot be empty.');
        }

        foreach($namespace as $onePart) {
            if (empty($onePart) || !is_string($onePart)) {
                throw new NamespaceException('The namespace array must only contain non-empty string elements.');
            }
        }

        $this->namespace = $namespace;
    }

    public function getName() {
        return $this->namespace[count($this->namespace) - 1];
    }

    public function getPath() {
        $output = [];
        $to = count($this->namespace) - 1;
        for($i = 0; $i < $to; $i++) {
            $output[] = $this->namespace[$i];
        }
        return $output;
    }

    public function getAll() {
        return $this->namespace;
    }

}
