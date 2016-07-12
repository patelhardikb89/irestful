<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethodReturnedInterface;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Exceptions\NamespaceException;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;

final class ConcreteMethodReturnedInterfaceAdapter implements  ReturnedInterfaceAdapter {
    private $namespaceAdapter;
    public function __construct(NamespaceAdapter $namespaceAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
    }

    public function fromTypeToReturnedInterface(Type $type) {

        try {

            $typeName = $type->getName();
            $name = $this->fromNameToInterfaceName($typeName);
            $namespace = $this->namespaceAdapter->fromDataToNamespace([$name]);
            return new ConcreteMethodReturnedInterface($name, $namespace);

        } catch (NamespaceException $exception) {
            throw new ReturnedInterfaceException('There was an exception while converting data to a Namespace object.', $exception);
        }

    }

    public function fromObjectToReturnedInterface(Object $object) {

        try {

            $objectName = $object->getName();
            $name = $this->fromNameToInterfaceName($objectName);
            $namespace = $this->namespaceAdapter->fromDataToNamespace([$name]);
            return new ConcreteMethodReturnedInterface($name, $namespace);

        } catch (NamespaceException $exception) {
            throw new ReturnedInterfaceException('There was an exception while converting data to a Namespace object.', $exception);
        }
    }

    public function fromPropertyTypeToReturnedInterface(PropertyType $propertyType) {

        if ($propertyType->hasType()) {
            $type = $propertyType->getType();
            return $this->fromTypeToReturnedInterface($type);
        }

        if ($propertyType->hasObject()) {
            $object = $propertyType->getObject();
            return $this->fromObjectToReturnedInterface($object);
        }

        throw new ReturnedInterfaceException('The PropertyType did not have a Type and an Object.');

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
