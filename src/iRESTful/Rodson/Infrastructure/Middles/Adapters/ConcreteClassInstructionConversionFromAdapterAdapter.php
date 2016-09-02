<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Adapters\Adapters\FromAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionFromAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Exceptions\FromException;

final class ConcreteClassInstructionConversionFromAdapterAdapter implements FromAdapterAdapter {

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

        return new ConcreteClassInstructionConversionFromAdapter($data['input'], $assignments);

    }

}
