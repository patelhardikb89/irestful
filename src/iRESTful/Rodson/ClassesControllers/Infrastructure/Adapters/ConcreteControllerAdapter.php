<?php
namespace iRESTful\Rodson\ClassesControllers\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesControllers\Domain\Adapters\ControllerAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\ClassesControllers\Infrastructure\Objects\ConcreteController;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $customMethodAdapter;
    private $constructorAdapter;
    private $namespaceAdapter;
    private $annotatedEntities;
    private $converters;
    public function __construct(
        CustomMethodAdapter $customMethodAdapter,
        ConstructorAdapter $constructorAdapter,
        ClassNamespaceAdapter $namespaceAdapter,
        array $annotatedEntities,
        array $converters
    ) {
        $this->customMethodAdapter = $customMethodAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
        $this->annotatedEntities = $annotatedEntities;
        $this->converters = $converters;
    }

    public function fromDSLControllersToControllers(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $name = $oneController->getName();
            $output[$name] = $this->fromDSLControllerToController($oneController);
        }

        return $output;
    }

    public function fromDSLControllerToController(Controller $controller) {

        $namespace = $this->namespaceAdapter->fromControllerToNamespace($controller);
        $constructor = $this->constructorAdapter->fromControllerToConstructor($controller);
        $customMethod = $this->customMethodAdapter->fromControllerToCustomMethod($controller);

        return new ConcreteController($namespace, $constructor, $customMethod);
    }

}
