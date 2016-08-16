<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Adapters\Adapters\ElementAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Exceptions\ConversionException;

final class ConcreteClassInstructionConversionAdapterAdapter implements ConversionAdapterAdapter {
    private $elementAdapterAdapter;
    public function __construct(ElementAdapterAdapter $elementAdapterAdapter) {
        $this->elementAdapterAdapter = $elementAdapterAdapter;
    }

    public function fromDataToConversionAdapter(array $data) {

        if (!isset($data['classes'])) {
            throw new ConversionException('The classes keyname is mandatory in order to convert data to a ConversionAdapter object.');
        }

        if (!isset($data['input'])) {
            throw new ConversionException('The input keyname is mandatory in order to convert data to a ConversionAdapter object.');
        }

        if (!isset($data['previous_assignments'])) {
            throw new ConversionException('The previous_assignments keyname is mandatory in order to convert data to a ConversionAdapter object.');
        }

        return new ConcreteClassInstructionConversionAdapter($this->elementAdapterAdapter, $data['classes'], $data['previous_assignments'], $data['input']);
    }

}
