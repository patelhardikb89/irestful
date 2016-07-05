<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObjectProperty;
use iRESTful\Rodson\Domain\Objects\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\Domain\Objects\Properties\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyAdapter implements PropertyAdapter {
    private $typeAdapter;
    public function __construct(TypeAdapter $typeAdapter) {
        $this->typeAdapter = $typeAdapter;
    }

    public function fromDataToProperties(array $data) {

        $output = [];
        foreach($data as $name => $type) {

            $optionalPos = strrpos($name, '?');
            $isOptional = (($optionalPos + 1) == strlen($name));
            if ($isOptional) {
                $name = substr($name, 0, $optionalPos);
            }

            $output[] = $this->fromDataToProperty([
                'name' => $name,
                'type' => $type,
                'is_optional' => $isOptional
            ]);
        }

        return $output;
    }

    public function fromDataToProperty(array $data) {

        if (!isset($data['name'])) {
            throw new PropertyException('The name keyname is mandatory in order to convert dat to a Property object.');
        }

        if (!isset($data['type'])) {
            throw new PropertyException('The type keyname is mandatory in order to convert dat to a Property object.');
        }

        $isOptional = false;
        if (isset($data['is_optional'])) {
            $isOptional = (bool) $data['is_optional'];
        }

        try {

            $type = $this->typeAdapter->fromStringToType($data['type']);
            return new ConcreteObjectProperty($data['name'], $type, $isOptional);

        } catch (TypeException $exception) {
            throw new PropertyException('There was an exception while converting a string to a Type object.', $exception);
        }
    }

}
