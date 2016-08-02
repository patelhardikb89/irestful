<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteObjectProperty;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyAdapter implements PropertyAdapter {
    private $typeAdapter;
    public function __construct(TypeAdapter $typeAdapter) {
        $this->typeAdapter = $typeAdapter;
    }

    public function fromDataToProperties(array $data) {

        $output = [];
        foreach($data as $name => $type) {

            $isOptional = false;
            $isUnique = false;
            $isKey = false;
            $default = null;

            $exploded = explode('|', $name);
            $amountPieces = count($exploded);
            if (count($exploded) >= 2) {

                if ($amountPieces != 2) {
                    throw new PropertyException('There is more than 1 pipe (|) in the given property name ('.$name.').  Only 1 is allowed.');
                }

                $name = $exploded[0];
                if (strrpos($exploded[1], '?') !== false) {
                    $isOptional = true;
                }

                if (strrpos($exploded[1], 'u') !== false) {
                    $isUnique = true;
                }

                if (strrpos($exploded[1], 'k') !== false) {
                    $isKey = true;
                }

                if (strrpos($exploded[1], 'd') !== false) {
                    $defaultExploded = explode('=', $exploded[1]);
                    if (count($defaultExploded) != 2) {
                        throw new PropertyException('There is 2 equals (=) in the given property name ('.$name.').  Only 1 is allowed.');
                    }

                    $default = $defaultExploded[1];
                }
            }

            $output[] = $this->fromDataToProperty([
                'name' => $name,
                'type' => $type,
                'is_optional' => $isOptional,
                'is_unique' => $isUnique,
                'is_key' => $isKey,
                'default' => $default
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

        $isUnique = false;
        if (isset($data['is_unique'])) {
            $isUnique = (bool) $data['is_unique'];
        }

        $isKey = false;
        if (isset($data['is_key'])) {
            $isKey = (bool) $data['is_key'];
        }

        $default = null;
        if (isset($data['default'])) {
            $default = $data['default'];
        }

        try {

            $type = $this->typeAdapter->fromStringToType($data['type']);
            return new ConcreteObjectProperty($data['name'], $type, $isOptional, $isUnique, $isKey, $default);

        } catch (TypeException $exception) {
            throw new PropertyException('There was an exception while converting a string to a Type object.', $exception);
        }
    }

}
