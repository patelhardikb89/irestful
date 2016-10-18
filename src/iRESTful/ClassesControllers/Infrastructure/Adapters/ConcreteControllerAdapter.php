<?php
namespace iRESTful\ClassesControllers\Infrastructure\Adapters;
use iRESTful\ClassesControllers\Domain\Adapters\ControllerAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\ClassesControllers\Infrastructure\Objects\ConcreteController;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $instructionAdapterAdapter;
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    private $annotatedEntities;
    public function __construct(
        InstructionAdapterAdapter $instructionAdapterAdapter,
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        ClassNamespaceAdapter $namespaceAdapter,
        array $annotatedEntities
    ) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
        $this->annotatedEntities = $annotatedEntities;
    }

    public function fromDSLControllersToControllers(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromDSLControllerToController($oneController);
        }

        return $output;
    }
    
    public function fromDSLControllerToController(Controller $controller) {

        $instructions = $this->instructionAdapterAdapter->fromAnnotatedEntitiesToInstructionAdapter($this->annotatedEntities)
                                                        ->fromDSLControllerToInstructions($controller);

        $namespace = $this->namespaceAdapter->fromControllerToNamespace($controller);

        $constructor = $this->constructorAdapter->fromInstructionsToConstructor($instructions);
        $customMethod = $this->customMethodAdapter->fromControllerInstructionsToCustomMethod($instructions);

        return new ConcreteController($namespace, $constructor, $customMethod);
    }

}
