<?php
namespace iRESTful\ClassesControllers\Infrastructure\Adapters;
use iRESTful\ClassesControllers\Domain\Adapters\Adapters\ControllerAdapterAdapter;
use iRESTful\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\ClassesControllers\Infrastructure\Adapters\ConcreteControllerAdapter;

final class ConcreteControllerAdapterAdapter implements ControllerAdapterAdapter {
    private $instructionAdapterAdapter;
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    public function __construct(
        InstructionAdapterAdapter $instructionAdapterAdapter,
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        ClassNamespaceAdapter $namespaceAdapter
    ) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
    }

    public function fromAnnotatedEntitiesToControllerAdapter(array $annotatedEntities) {
        return new ConcreteControllerAdapter(
            $this->instructionAdapterAdapter,
            $this->customMethodAdapter,
            $this->constructorAdapter,
            $this->namespaceAdapter,
            $annotatedEntities
        );
    }

}
