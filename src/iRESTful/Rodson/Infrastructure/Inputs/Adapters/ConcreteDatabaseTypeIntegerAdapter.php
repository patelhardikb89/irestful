<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Integers\Adapters\IntegerAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteDatabaseTypeInteger;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Integers\Exceptions\IntegerException;

final class ConcreteDatabaseTypeIntegerAdapter implements IntegerAdapter {

    public function __construct() {

    }

    public function fromDataToInteger(array $data) {

        if (!isset($data['max'])) {
            throw new IntegerException('The max keyname is mandatory in order to convert data to an Integer object.');
        }

        $max = (int) $data['max'];
        return new ConcreteDatabaseTypeInteger($max);

    }

}
