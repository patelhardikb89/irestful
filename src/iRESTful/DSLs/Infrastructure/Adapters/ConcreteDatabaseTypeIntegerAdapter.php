<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Integers\Adapters\IntegerAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseTypeInteger;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Integers\Exceptions\IntegerException;

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
