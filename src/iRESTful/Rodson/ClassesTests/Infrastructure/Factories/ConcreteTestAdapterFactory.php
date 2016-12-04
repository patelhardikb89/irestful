<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Factories;
use iRESTful\Rodson\ClassesTests\Domain\Adapters\Factories\TestAdapterFactory;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestTransformAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestControllerAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestCRUDAdapter;

final class ConcreteTestAdapterFactory implements TestAdapterFactory {
    private $baseNamespaces;
    public function __construct(array $baseNamespaces) {
        $this->baseNamespaces = $baseNamespaces;
    }

    public function create() {
        $testTransformAdapter = new ConcreteTestTransformAdapter($this->baseNamespaces);
        $testCRUDAdapter = new ConcreteTestCRUDAdapter($this->baseNamespaces);
        $testControllerAdapter = new ConcreteTestControllerAdapter($this->baseNamespaces);

        return new ConcreteTestAdapter($testTransformAdapter, $testCRUDAdapter, $testControllerAdapter);
    }

}
