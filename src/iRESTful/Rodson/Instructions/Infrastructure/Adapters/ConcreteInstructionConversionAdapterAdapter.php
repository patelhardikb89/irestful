<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\Adapters\Adapters\FromAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\Exceptions\ConversionException;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\Adapters\Adapters\ToAdapterAdapter;

final class ConcreteInstructionConversionAdapterAdapter implements ConversionAdapterAdapter {
    private $fromAdapterAdapter;
    private $toAdapterAdapter;
    public function __construct(FromAdapterAdapter $fromAdapterAdapter, ToAdapterAdapter $toAdapterAdapter) {
        $this->fromAdapterAdapter = $fromAdapterAdapter;
        $this->toAdapterAdapter = $toAdapterAdapter;
    }

    public function fromDataToConversionAdapter(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new ConversionException('The annotated_entities keyname is mandatory in order to convert data to a ConversionAdapter object.');
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
            'annotated_entities' => $data['annotated_entities']
        ]);

        return new ConcreteInstructionConversionAdapter($fromAdapter, $toAdapter);
    }

}
