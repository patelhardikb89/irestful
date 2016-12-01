<?php
namespace iRESTful\Rodson\ClassesControllers\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesControllers\Domain\Adapters\ControllerAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\ClassesControllers\Infrastructure\Objects\ConcreteController;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $instructionAdapterAdapter;
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    private $annotatedEntities;
    private $converters;
    public function __construct(
        InstructionAdapterAdapter $instructionAdapterAdapter,
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        ClassNamespaceAdapter $namespaceAdapter,
        array $annotatedEntities,
        array $converters
    ) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
        $this->annotatedEntities = $annotatedEntities;
        $this->converters = $converters;
    }

    public function fromDSLControllersToControllers(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromDSLControllerToController($oneController);
        }

        return $output;
    }

    public function fromDSLControllerToController(Controller $controller) {

        $instructions = $this->instructionAdapterAdapter->fromDataToInstructionAdapter([
                                                            'annotated_entities' => $this->annotatedEntities,
                                                            'converters' => $this->converters
                                                        ])
                                                        ->fromDSLControllerToInstructions($controller);

        $namespace = $this->namespaceAdapter->fromControllerToNamespace($controller);

        $constructor = $this->constructorAdapter->fromInstructionsToConstructor($instructions);
        $customMethod = $this->customMethodAdapter->fromControllerInstructionsToCustomMethod($instructions);

        return new ConcreteController($namespace, $constructor, $customMethod);
    }

}
