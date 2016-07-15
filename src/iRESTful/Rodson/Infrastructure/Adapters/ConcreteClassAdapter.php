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

final class ConcreteClassAdapter implements ClassAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $methodAdapter;
    private $propertyAdapter;
    public function __construct(NamespaceAdapter $namespaceAdapter, InterfaceAdapter $interfaceAdapter, MethodAdapter $methodAdapter, PropertyAdapter $propertyAdapter) {
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
    
    public function fromControllerToClass(Controller $controller) {

    }

    public function fromControllersToClasses(array $controllers) {

        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromControllerToClass($oneController);
        }

        return $output;

    }

}
