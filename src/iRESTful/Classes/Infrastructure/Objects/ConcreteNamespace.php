<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\Namespaces\Exceptions\NamespaceException;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;

final class ConcreteNamespace implements ClassNamespace {
    private $namespace;
    private $name;
    private $path;
    private $all;
    private $allEscaped;
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
        $this->name = $namespace[count($namespace) - 1];
        $this->path = implode('\\', $this->getPath());
        $this->all = implode('\\', $namespace);
        $this->allEscaped = str_replace('\\', '\\\\', $this->getAllAsString());
    }

    public function getName() {
        return $this->name;
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

    public function getAllAsString() {
        return $this->all;
    }

    public function getPathAsString() {
        return $this->path;
    }

    public function getData() {
        return [
            'name' => $this->getName(),
            'path' => $this->getPathAsString(),
            'all' => $this->getAllAsString(),
            'all_escaped' => str_replace('\\', '\\\\', $this->getAllAsString())
        ];
    }

}
