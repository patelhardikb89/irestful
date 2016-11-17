<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Binaries\Adapters\BinaryAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteDatabaseTypeBinary;

final class ConcreteDatabaseTypeBinaryAdapter implements BinaryAdapter {

    public function __construct() {

    }

    public function fromDataToBinary(array $data) {

        $specific = null;
        if (isset($data['specific'])) {
            $specific = (int) $data['specific'];
        }

        $max = null;
        if (isset($data['max'])) {
            $max = (int) $data['max'];
        }

        return new ConcreteDatabaseTypeBinary($specific, $max);

    }

}
