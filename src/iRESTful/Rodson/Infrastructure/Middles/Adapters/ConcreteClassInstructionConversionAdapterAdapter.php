<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Adapters\Adapters\FromAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Exceptions\ConversionException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\Adapters\ToAdapterAdapter;

final class ConcreteClassInstructionConversionAdapterAdapter implements ConversionAdapterAdapter {
    private $fromAdapterAdapter;
    private $toAdapterAdapter;
    public function __construct(FromAdapterAdapter $fromAdapterAdapter, ToAdapterAdapter $toAdapterAdapter) {
        $this->fromAdapterAdapter = $fromAdapterAdapter;
        $this->toAdapterAdapter = $toAdapterAdapter;
    }

    public function fromDataToConversionAdapter(array $data) {

        if (!isset($data['annotated_classes'])) {
            throw new ConversionException('The annotated_classes keyname is mandatory in order to convert data to a ConversionAdapter object.');
        }

        if (!isset($data['input'])) {
            throw new ConversionException('The input keyname is mandatory in order to convert data to a ConversionAdapter object.');
        }

        if (!isset($data['previous_assignments'])) {
            throw new ConversionException('The previous_assignments keyname is mandatory in order to convert data to a ConversionAdapter object.');
        }

        $fromAdapter = $this->fromAdapterAdapter->fromDataToFromAdapter([
            'input' => $data['input'],
            'assignments' => $data['previous_assignments']
        ]);

        $toAdapter = $this->toAdapterAdapter->fromDataToToAdapter([
            'annotated_classes' => $data['annotated_classes']
        ]);

        return new ConcreteClassInstructionConversionAdapter($fromAdapter, $toAdapter);
    }

}
