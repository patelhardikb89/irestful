<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\Adapters\Adapters\FromAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionFromAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\Exceptions\FromException;

final class ConcreteInstructionConversionFromAdapterAdapter implements FromAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToFromAdapter(array $data) {

        if (!isset($data['input'])) {
            throw new FromException('The input keyname is mandatory in order to convert data to a FromAdapter object.');
        }

        $assignments = [];
        if (isset($data['assignments'])) {
            $assignments = $data['assignments'];
        }

        return new ConcreteInstructionConversionFromAdapter($data['input'], $assignments);

    }

}
