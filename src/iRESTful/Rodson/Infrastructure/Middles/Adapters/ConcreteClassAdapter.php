<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Adapters\ClassAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Adapters\InputAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClass;
use iRESTful\Rodson\Domain\Inputs\Rodson;

final class ConcreteClassAdapter implements ClassAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $customMethodAdapter;
    private $inputAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        CustomMethodAdapter $customMethodAdapter,
        InputAdapter $inputAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->inputAdapter = $inputAdapter;
    }

    public function fromRodsonToClasses(Rodson $rodson) {

        $objects = $rodson->getObjects();
        $controllers = $rodson->getControllers();

        $objectClasses = $this->fromObjectsToClasses($objects);
        $objectTypeClasses = $this->fromObjectsToTypeClasses($objects);
        $controllerClasses = [];//$this->fromControllersToClasses($controllers);

        return array_merge($objectClasses, $objectTypeClasses, $controllerClasses);
    }

    private function fromObjectsToTypeClasses(array $objects) {
        $getTypes = function(array $objects) {
            $getTypes = function(Object $object) {
                $types = [];
                $properties = $object->getProperties();
                foreach($properties as $oneProperty) {
                    $propertyType = $oneProperty->getType();
                    if ($propertyType->hasType()) {
                        $types[] = $propertyType->getType();
                    }
                }

                return $types;
            };

            $output = [];
            foreach($objects as $oneObject) {
                $objectTypes = $getTypes($oneObject);
                foreach($objectTypes as $oneObjectType) {
                    $name = $oneObjectType->getName();
                    $output[$name] = $oneObjectType;
                }
            }

            return array_values($output);
        };

        $types = $getTypes($objects);
        return $this->fromTypesToClasses($types);
    }

    private function fromObjectToClass(Object $object) {

        $namespace = $this->namespaceAdapter->fromObjectToNamespace($object);
        $interface = $this->interfaceAdapter->fromObjectToInterface($object);
        $constructor = $this->constructorAdapter->fromObjectToConstructor($object);
        $customMethods = $this->customMethodAdapter->fromObjectToCustomMethods($object);
        $classInput = $this->inputAdapter->fromObjectToInput($object);

        $name = $namespace->getName();
        return new ConcreteClass(
            $name,
            $classInput,
            $namespace,
            $interface,
            $constructor,
            $customMethods
        );
    }

    private function fromObjectsToClasses(array $objects) {
        $output = [];
        foreach($objects as $oneObject) {
            $output[] = $this->fromObjectToClass($oneObject);
        }

        return $output;
    }

    private function fromTypesToClasses(array $types) {
        $output = [];
        foreach($types as $oneType) {
            $output[] = $this->fromTypeToClass($oneType);
        }

        return $output;
    }

    private function fromTypeToClass(Type $type) {
        $namespace = $this->namespaceAdapter->fromTypeToNamespace($type);
        $interface = $this->interfaceAdapter->fromTypeToInterface($type);
        $constructor = $this->constructorAdapter->fromTypeToConstructor($type);
        $customMethod = $this->customMethodAdapter->fromTypeToCustomMethod($type);
        $classInput = $this->inputAdapter->fromTypeToInput($type);

        $customMethods = null;
        if (!empty($customMethod)) {
            $customMethods = [$customMethod];
        }

        $subClasses = [];
        if ($type->hasViewAdapter() || $type->hasDatabaseAdapter()) {
            $subClasses[] = $this->fromTypeToAdapterClass($type);
        }

        $name = $namespace->getName();
        return new ConcreteClass($name, $classInput, $namespace, $interface, $constructor, $customMethods, $subClasses);
    }

    private function fromControllerToClass(Controller $controller) {

    }

    private function fromControllersToClasses(array $controllers) {

    }

    private function fromTypeToAdapterClass(Type $type) {
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interface = $this->interfaceAdapter->fromTypeToAdapterInterface($type);
        $constructor = $this->constructorAdapter->fromTypeToAdapterConstructor($type);
        $customMethods = $this->customMethodAdapter->fromTypeToAdapterCustomMethods($type);
        $classInput = $this->inputAdapter->fromTypeToInput($type);

        $name = $namespace->getName();
        return new ConcreteClass($name, $classInput, $namespace, $interface, $constructor, $customMethods);
    }
}
