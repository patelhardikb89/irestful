<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Adapters;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Adapters\ControllerNodeAdapter;
use iRESTful\ClassesConfigurations\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Objects\ConcreteConfigurationControllerNode;

final class ConcreteConfigurationControllerNodeAdapter implements ControllerNodeAdapter {
    private $controllerAdapter;
    public function __construct(ControllerAdapter $controllerAdapter) {
        $this->controllerAdapter = $controllerAdapter;
    }

    public function fromDataToControllerNode(array $data) {

        $namespaces = [];
        $parameters = [];
        $controllers = $this->controllerAdapter->fromDataToControllers($data);

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

                $parameterName = $parameter->getName();
                $parameters[$parameterName] = $oneParameter;
            }
        }

        return new ConcreteConfigurationControllerNode($controllers, array_values($namespaces), array_values($parameters));

    }

}
