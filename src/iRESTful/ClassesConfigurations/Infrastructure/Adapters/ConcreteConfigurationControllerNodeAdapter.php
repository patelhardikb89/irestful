<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Adapters;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Adapters\ControllerNodeAdapter;
use iRESTful\ClassesConfigurations\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Objects\ConcreteConfigurationControllerNode;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Parameters\Adapters\ParameterAdapter;

final class ConcreteConfigurationControllerNodeAdapter implements ControllerNodeAdapter {
    private $controllerAdapter;
    private $parameterAdapter;
    public function __construct(ControllerAdapter $controllerAdapter, ParameterAdapter $parameterAdapter) {
        $this->controllerAdapter = $controllerAdapter;
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromDataToControllerNode(array $data) {

        $namespaces = [];
        $controllers = $this->controllerAdapter->fromDataToControllers($data);
        $parameters = $this->parameterAdapter->fromControllersToParameters($controllers);

        foreach($controllers as $oneController) {
            $controllerClass = $oneController->getControllerClass();
            $namespace = $controllerClass->getNamespace();
            $constructorParameters = $controllerClass->getConstructor()->getParameters();

            $namespaces[$namespace->getAllAsString()] = $namespace;
            foreach($constructorParameters as $oneParameter) {
                $parameter = $oneParameter->getParameter();
                $type = $parameter->getType();

                if ($type->hasNamespace()) {
                    $typeNamespace = $type->getNamespace();
                    $namespaces[$typeNamespace->getAllAsString()] = $typeNamespace;
                }
            }
        }

        return new ConcreteConfigurationControllerNode($controllers, array_values($namespaces), $parameters);
    }

}
