<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;

final class ConcreteSpecificClassTestController implements Controller {
    private $namespace;
    private $customMethods;
    public function __construct(ClassNamespace $namespace, array $customMethods) {
        $this->namespace = $namespace;
        $this->customMethods = $customMethods;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

    public function getData() {

        $customMethods = $this->getCustomMethods();
        array_walk($customMethods, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'namespace' => $this->namespace->getData(),
            'custom_methods' => $customMethods
        ];
    }

}
