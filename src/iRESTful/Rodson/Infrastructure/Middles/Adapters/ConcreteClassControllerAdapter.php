<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassController;

final class ConcreteClassControllerAdapter implements ControllerAdapter {
    private $instructionAdapterAdapter;
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    private $annotatedClasses;
    public function __construct(
        InstructionAdapterAdapter $instructionAdapterAdapter,
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        NamespaceAdapter $namespaceAdapter,
        array $annotatedClasses
    ) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
        $this->annotatedClasses = $annotatedClasses;
    }

    public function fromRodsonToClassControllers(Rodson $rodson) {
        $controllers = $rodson->getControllers();
        return $this->fromControllersToClassControllers($controllers);
    }

    private function fromControllersToClassControllers(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromControllerToClassController($oneController);
        }

        return $output;
    }

    private function fromControllerToClassController(Controller $controller) {

        $instructions = $this->instructionAdapterAdapter->fromAnnotatedClassesToInstructionAdapter($this->annotatedClasses)
                                                        ->fromControllerToInstructions($controller);

        $namespace = $this->namespaceAdapter->fromControllerToNamespace($controller);
        $constructor = $this->constructorAdapter->fromInstructionsToConstructor($instructions);
        $customMethod = $this->customMethodAdapter->fromInstructionsToCustomMethod($instructions);

        $name = $namespace->getName();
        return new ConcreteClassController($name, $namespace, $constructor, $customMethod);
    }

}
