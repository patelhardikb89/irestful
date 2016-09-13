<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Adapters\BinaryAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteDatabaseTypeBinary;

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
