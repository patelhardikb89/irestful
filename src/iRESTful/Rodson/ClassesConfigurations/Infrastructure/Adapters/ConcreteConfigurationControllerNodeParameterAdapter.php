<?php
namespace iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Nodes\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Objects\ConcreteConfigurationControllerNodeParameter;
use iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Nodes\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;

final class ConcreteConfigurationControllerNodeParameterAdapter implements ParameterAdapter {
    private $classNamespaceAdapter;
    private $dependenciesInterfaceClassMapper;
    public function __construct(ClassNamespaceAdapter $classNamespaceAdapter, array $dependenciesInterfaceClassMapper) {
        $this->classNamespaceAdapter = $classNamespaceAdapter;
        $this->dependenciesInterfaceClassMapper = $dependenciesInterfaceClassMapper;
    }

    public function fromControllersToParameters(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $constructorParameters = $oneController->getControllerClass()->getConstructor()->getParameters();
            foreach($constructorParameters as $oneParameter) {

                $parameter = $oneParameter->getParameter();
                $name = $parameter->getName();
                if (isset($output[$name])) {
                    continue;
                }

                $type = $parameter->getType();

                $classNamespace = null;
                if ($type->hasNamespace()) {
                    $interfaceNamespace = $type->getNamespace()->getAllAsString();
                    if (!isset($this->dependenciesInterfaceClassMapper[$interfaceNamespace])) {
                        throw new ParameterException('The interface ('.$interfaceNamespace.') do not have a matching class in the given dependencies interface class mapper.');
                    }

                    $namespaceData = explode('\\', $this->dependenciesInterfaceClassMapper[$interfaceNamespace]);
                    $classNamespace = $this->classNamespaceAdapter->fromFullDataToNamespace($namespaceData);
                }

                $output[$name] = new ConcreteConfigurationControllerNodeParameter($oneParameter, $classNamespace);
            }
        }

        return array_values($output);
    }

}
