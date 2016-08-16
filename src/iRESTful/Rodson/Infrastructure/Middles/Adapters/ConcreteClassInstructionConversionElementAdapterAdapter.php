<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Adapters\Adapters\ElementAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionElementAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Exceptions\ElementException;

final class ConcreteClassInstructionConversionElementAdapterAdapter implements ElementAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToElementAdapter(array $data) {

        if (!isset($data['input'])) {
            throw new ElementException('The input keyname is mandatory in order to convert data to an Element object.');
        }

        $classes = [];
        if (isset($data['classes'])) {
            $classes = $data['classes'];
        }

        $assignments = [];
        if (isset($data['assignments'])) {
            $assignments = $data['assignments'];
        }

        return new ConcreteClassInstructionConversionElementAdapter($data['input'], $classes, $assignments);

    }

}
