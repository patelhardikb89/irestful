<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteInterface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;

final class ConcreteInterfaceAdapter implements InterfaceAdapter {
    private $methodAdapter;
    public function __construct(MethodAdapter $methodAdapter) {
        $this->methodAdapter = $methodAdapter;
    }

    public function fromObjectToInterface(Object $object) {

        try {

            $name = $this->fromNameToInterfaceName($object->getName());
            $properties = $object->getProperties();
            $methods = $this->methodAdapter->fromPropertiesToMethods($properties);
            $subInterfaces = $this->fromPropertyTypesToInterfaces($properties);

            return new ConcreteInterface($name, $methods, $subInterfaces);

        } catch (MethodException $exception) {
            throw new InterfaceException('There was an exception while converting Property objects to Method objects.', $exception);
        }

    }

    public function fromTypeToInterface(Type $type) {

        try {

            $name = $this->fromNameToInterfaceName($type->getName());
            $methods = $this->methodAdapter->fromDataToMethods([
                'name' => 'get'
            ]);

            $attachedInterfaces = $this->fromTypeToAttachedInterfaces($type);
            return new ConcreteInterface($name, $methods, null, $attachedInterfaces);

        } catch (MethodException $exception) {
            throw new InterfaceException('There was an exception while converting data to Method objects.', $exception);
        }

    }

    public function fromPropertyTypesToInterfaces(array $propertyTypes) {
        $output = [];
        foreach($propertyTypes as $onePropertyType) {
            $output[] = $this->fromPropertyTypeToInterface($onePropertyType);
        }

        return $output;
    }

    public function fromPropertyTypeToInterface(PropertyType $propertyType) {

        if ($propertyType->hasType()) {
            $type = $propertyType->getType();
            return $this->fromTypeToInterface($type);
        }

        if ($propertyType->hasObject()) {
            $object = $propertyType->getObject();
            return $this->fromObjectToInterface($object);
        }

        throw new InterfaceException('There was no Type or Object inside the given PropertyType.');

    }

    private function fromTypeToAttachedInterfaces(Type $type) {

        $name = $this->fromNameToInterfaceName($type->getName().'Adapter');

        $methods = [];
        if ($type->hasDatabaseAdapter()) {
            $databaseAdapter = $type->getDatabaseAdapter();
            $methods[] = $this->methodAdapter->fromAdapterToMethod($databaseAdapter);
        }

        if ($type->hasViewAdapter()) {
            $viewAdapter = $type->getViewAdapter();
            $methods[] = $this->methodAdapter->fromAdapterToMethod($viewAdapter);
        }

        $adapterInterface = new ConcreteInterface($name, $methods);
        return [
            $adapterInterface
        ];
    }

    private function fromNameToInterfaceName($name) {
        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return $name;
    }

}
