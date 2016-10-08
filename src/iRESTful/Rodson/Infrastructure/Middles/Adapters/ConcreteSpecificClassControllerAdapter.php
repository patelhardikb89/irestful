<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassController;

final class ConcreteSpecificClassControllerAdapter implements ControllerAdapter {
    private $instructionAdapterAdapter;
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    private $annotatedEntities;
    public function __construct(
        InstructionAdapterAdapter $instructionAdapterAdapter,
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        NamespaceAdapter $namespaceAdapter,
        array $annotatedEntities
    ) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
        $this->annotatedEntities = $annotatedEntities;
    }

    public function fromControllersToSpecificControllers(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromControllerToSpecificController($oneController);
        }

        return $output;
    }

    public function fromControllerToSpecificController(Controller $controller) {

        $instructions = $this->instructionAdapterAdapter->fromAnnotatedEntitiesToInstructionAdapter($this->annotatedEntities)
                                                        ->fromControllerToInstructions($controller);

        $namespace = $this->namespaceAdapter->fromControllerToNamespace($controller);
        $constructor = $this->constructorAdapter->fromInstructionsToConstructor($instructions);
        $customMethod = $this->customMethodAdapter->fromControllerInstructionsToCustomMethod($instructions);

        return new ConcreteSpecificClassController($namespace, $constructor, $customMethod);
    }

}
