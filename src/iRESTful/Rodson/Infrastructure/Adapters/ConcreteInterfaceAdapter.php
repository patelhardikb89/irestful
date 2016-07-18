<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteInterface;
use iRESTful\Rodson\Domain\Outputs\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Exceptions\NamespaceException;

final class ConcreteInterfaceAdapter implements InterfaceAdapter {
    private $methodAdapter;
    private $namespaceAdapter;
    public function __construct(MethodAdapter $methodAdapter, NamespaceAdapter $namespaceAdapter) {
        $this->methodAdapter = $methodAdapter;
        $this->namespaceAdapter = $namespaceAdapter;
    }

    public function fromObjectToInterface(Object $object) {
        return $this->fromObjectToInterfaceWithNamespacePrefix($object);

    }

    public function fromTypeToInterface(Type $type) {
        return $this->fromTypeToInterfaceWithNamespacePrefix($type);
    }

    public function fromTypeToAdapterInterface(Type $type) {
        return $this->fromTypeToAdapterInterfaceWithNamespacePrefix($type);
    }

    public function fromPropertiesToInterfaces(array $properties) {
        return $this->fromPropertiesToInterfacesWithNamespacePrefix($properties, []);
    }

    public function fromPropertyTypeToInterface(PropertyType $propertyType) {
        return $this->fromPropertiesToInterfacesWithNamespacePrefix($propertyType, []);
    }

    private function fromTypeToAdapterInterfaceWithNamespacePrefix(Type $type, array $namespacePrefix = []) {

        $typeName = $type->getName();
        $name = $this->fromNameToInterfaceName($typeName).'Adapter';
        $methods = $this->methodAdapter->fromTypeToMethods($type);

        if (empty($methods)) {
            return null;
        }

        $namespace = $this->namespaceAdapter->fromDataToNamespace(array_merge($namespacePrefix, ['Adapters']));
        return new ConcreteInterface($name, $methods, $namespace);
    }

    private function fromObjectToInterfaceWithNamespacePrefix(Object $object, array $namespacePrefix = []) {
        try {

            $objectName = $object->getName();
            $name = $this->fromNameToInterfaceName($objectName);
            $properties = $object->getProperties();
            $methods = $this->methodAdapter->fromPropertiesToMethods($properties);
            $namespaceData = array_merge($namespacePrefix, [$name]);
            $namespace = $this->namespaceAdapter->fromDataToNamespace($namespaceData);
            $subInterfaces = $this->fromPropertiesToInterfacesWithNamespacePrefix($properties, $namespaceData);

            return new ConcreteInterface($name, $methods, $namespace, $subInterfaces);

        } catch (MethodException $exception) {
            throw new InterfaceException('There was an exception while converting Property objects to Method objects.', $exception);
        } catch (NamespaceException $exception) {
            throw new InterfaceException('There was an exception while converting data to a Namespace object.', $exception);
        }
    }

    private function fromTypeToInterfaceWithNamespacePrefix(Type $type, array $namespacePrefix = []) {
        try {

            $typeName = $type->getName();
            $name = $this->fromNameToInterfaceName($typeName);
            $method = $this->methodAdapter->fromDataToMethod([
                'name' => 'get'
            ]);

            $namespaceData = array_merge($namespacePrefix, [$name]);
            $namespace = $this->namespaceAdapter->fromDataToNamespace($namespaceData);
            return new ConcreteInterface($name, [$method], $namespace);

        } catch (MethodException $exception) {
            throw new InterfaceException('There was an exception while converting data to Method objects.', $exception);
        } catch (NamespaceException $exception) {
            throw new InterfaceException('There was an exception while converting data to a Namespace object.', $exception);
        }
    }

    private function fromPropertyTypeToInterfaceWithNamespacePrefix(PropertyType $propertyType, array $namespacePrefix) {

        if ($propertyType->hasType()) {
            $type = $propertyType->getType();
            return $this->fromTypeToInterfaceWithNamespacePrefix($type, $namespacePrefix);
        }

        if ($propertyType->hasObject()) {
            $object = $propertyType->getObject();
            return $this->fromObjectToInterfaceWithNamespacePrefix($object, $namespacePrefix);
        }

        throw new InterfaceException('There was no Type or Object inside the given PropertyType.');

    }

    private function fromPropertiesToInterfacesWithNamespacePrefix(array $properties, array $namespacePrefix) {
        $output = [];
        foreach($properties as $oneProperty) {
            $type = $oneProperty->getType();
            $output[] = $this->fromPropertyTypeToInterfaceWithNamespacePrefix($type, $namespacePrefix);
        }

        return $output;
    }

    private function fromNameToInterfaceName($name) {
        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return ucfirst($name);
    }

}
