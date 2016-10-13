<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\Adapters\StringAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseTypeString;

final class ConcreteDatabaseTypeStringAdapter implements StringAdapter {

    public function __construct() {

    }

    public function fromDataToString(array $data) {

        $specific = null;
        if (isset($data['specific'])) {
            $specific = (int) $data['specific'];
        }

        $max = null;
        if (isset($data['max'])) {
            $max = (int) $data['max'];
        }

        return new ConcreteDatabaseTypeString($specific, $max);

    }

}
