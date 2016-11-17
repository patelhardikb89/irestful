<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeBinary;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeString;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeFloat;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeInteger;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Adapters\TypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeAdapter implements TypeAdapter {

    public function __construct() {

    }

    public function fromDataToType(array $data) {

        if (!isset($data['name'])) {
            throw new TypeException('The name keyname is mandatory in order to convert data to a Type object.');
        }

        $binary = null;
        if ($data['name'] == 'binary') {

            $specific = null;
            if (isset($data['specific_bit_size'])) {
                $specific = (int) $data['specific_bit_size'];
            }

            $max = null;
            if (isset($data['max_bit_size'])) {
                $max = (int) $data['max_bit_size'];
            }

            $binary = new ConcreteTypeBinary($specific, $max);

        }

        $string = null;
        if ($data['name'] == 'string') {

            $specific = null;
            if (isset($data['specific_character_size'])) {
                $specific = (int) $data['specific_character_size'];
            }

            $max = null;
            if (isset($data['max_character_size'])) {
                $max = (int) $data['max_character_size'];
            }

            $string = new ConcreteTypeString($specific, $max);
        }

        $float = null;
        if ($data['name'] == 'float') {

            if (!isset($data['digits_amount'])) {
                throw new TypeException('The digits_amount keyname is mandatory in order to convert data to a float Type object.');
            }

            if (!isset($data['precision'])) {
                throw new TypeException('The precision keyname is mandatory in order to convert data to a float Type object.');
            }

            $digitsAmount = (int) $data['digits_amount'];
            $precision = (int) $data['precision'];
            $float = new ConcreteTypeFloat($digitsAmount, $precision);

        }

        $integer = null;
        if ($data['name'] == 'integer') {

            if (!isset($data['max_bit_size'])) {
                throw new TypeException('The max_bit_size keyname is mandatory in order to convert data to an integer Type object.');
            }

            $max = (int) $data['max_bit_size'];
            $integer = new ConcreteTypeInteger($max);

        }

        $boolean = false;
        if ($data['name'] == 'boolean') {
            $boolean = true;
        }

        return new ConcreteType($binary, $float, $integer, $string, $boolean);

    }

}
