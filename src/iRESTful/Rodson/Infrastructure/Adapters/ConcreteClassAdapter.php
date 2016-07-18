<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Classes\Adapters\ClassAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteClass;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\Domain\Outputs\Classes\Exceptions\ClassException;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Exceptions\NamespaceException;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;

final class ConcreteClassAdapter implements ClassAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $methodAdapter;
    private $propertyAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        MethodAdapter $methodAdapter,
        PropertyAdapter $propertyAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->methodAdapter = $methodAdapter;
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromObjectToClass(Object $object) {

        try {

            $isEntity = $object->hasDatabase();

            $interface = $this->interfaceAdapter->fromObjectToInterface($object);
            $constructor = $this->methodAdapter->fromObjectToConstructor($object);
            $methods = $this->methodAdapter->fromObjectToMethods($object);
            $properties = $this->propertyAdapter->fromObjectToProperties($object);

            $baseNamespace = 'Objects';
            if ($isEntity) {
                $baseNamespace = 'Entities';
            }

            $namespace = $this->namespaceAdapter->fromDataToNamespace([$baseNamespace]);

            $interfaceName = $interface->getName();
            $name = 'Concrete'.$interfaceName;

            return new ConcreteClass($name, $namespace, $interface, $constructor, $methods, $properties, $isEntity);

        } catch (InterfaceException $exception) {
            throw new ClassException('There was an exception while converting an Object to an Interface object.', $exception);
        } catch (MethodException $exception) {
            throw new ClassException('There was an exception while converting an Object to an constructor Method object.', $exception);
        } catch (PropertyException $exception) {
            throw new ClassException('There was an exception while converting an Object to a Property object.', $exception);
        } catch (NamespaceException $exception) {
            throw new ClassException('There was an exception while converting data to a Namespace object.', $exception);
        }

    }

    public function fromObjectsToClasses(array $objects) {

        $output = [];
        foreach($objects as $oneObject) {
            $output[] = $this->fromObjectToClass($oneObject);
        }

        return $output;

    }

    public function fromObjectsToTypeClasses(array $objects) {

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
        return $this->fromTypesToTypeClasses($types);
    }

    public function fromTypesToTypeClasses(array $types) {
        $output = [];
        foreach($types as $oneType) {
            $output[] = $this->fromTypeToTypeClass($oneType);
        }

        return $output;
    }

    public function fromTypeToTypeClass(Type $type) {


        try {

            $interface = $this->interfaceAdapter->fromTypeToInterface($type);
            $constructor = $this->methodAdapter->fromTypeToConstructor($type);
            $methods = $this->methodAdapter->fromTypeToMethods($type);
            $property = $this->propertyAdapter->fromTypeToProperty($type);
            $namespace = $this->namespaceAdapter->fromDataToNamespace(['Types']);

            $interfaceName = $interface->getName();
            $name = 'Concrete'.$interfaceName;

            $subClasses = [];
            if ($type->hasViewAdapter() || $type->hasDatabaseAdapter()) {
                $subClasses[] = $this->fromTypeToAdapterClass($type);
            }

            return new ConcreteClass($name, $namespace, $interface, $constructor, $methods, [$property], false, $subClasses);

        } catch (InterfaceException $exception) {
            throw new ClassException('There was an exception while converting an Object to an Interface object.', $exception);
        } catch (MethodException $exception) {
            throw new ClassException('There was an exception while converting an Object to an constructor Method object.', $exception);
        } catch (PropertyException $exception) {
            throw new ClassException('There was an exception while converting an Object to a Property object.', $exception);
        } catch (NamespaceException $exception) {
            throw new ClassException('There was an exception while converting data to a Namespace object.', $exception);
        }

    }

    public function fromControllerToClass(Controller $controller) {

    }

    public function fromControllersToClasses(array $controllers) {

        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromControllerToClass($oneController);
        }

        return $output;

    }

    public function fromTypeToAdapterClass(Type $type) {

        $adapterInterface = $this->interfaceAdapter->fromTypeToAdapterInterface($type);

        $subMethods = $adapterInterface->getMethods();
        $interfaceMethod = $type->getMethod();

        $constructor = $this->methodAdapter->fromEmptyToConstructor();
        $methods = $this->methodAdapter->fromTypeToCustomMethods($type);
        $namespace = $this->namespaceAdapter->fromDataToNamespace(['Types', 'Adapters']);

        $interfaceName = $adapterInterface->getName();
        $name = 'Concrete'.$interfaceName;

        return new ConcreteClass($name, $namespace,$adapterInterface, $constructor, $methods, [], false);


    }

}
