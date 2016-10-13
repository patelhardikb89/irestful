<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Converters\Adapters\ConverterAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteConverter;
use iRESTful\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Adapters\TypeAdapter;

final class ConcreteConverterAdapter implements ConverterAdapter {
    private $typeAdapter;
    private $types;
    private $primitives;
    public function __construct(TypeAdapter $typeAdapter, array $types, array $primitives) {
        $this->typeAdapter = $typeAdapter;
        $this->types = $types;
        $this->primitives = $primitives;
    }

    public function fromDataToConverters(array $data) {
        $output = [];
        foreach($data as $oneData) {

            if (!isset($oneData['from']) || !is_string($oneData['from'])) {
                throw new ConverterException('The data must contain from keynames.  The from keyname must also contain a string.');
            }

            if (!isset($oneData['to']) || !is_string($oneData['to'])) {
                throw new ConverterException('The data must contain to keynames.  The to keyname must also contain a string.');
            }

            $keyname = 'from_'.$oneData['from'].'_to_'.$oneData['to'];
            $output[$keyname] = $this->fromDataToConverter($oneData);
        }

        return $output;
    }

    public function fromDataToConverter(array $data) {

        $from = null;
        if (isset($data['from'])) {

            if (isset($this->types[$data['from']])) {
                $from = $this->typeAdapter->fromTypeToAdapterType($this->types[$data['from']]);
            }

            if (isset($this->primitives[$data['from']])) {
                $from = $this->typeAdapter->fromPrimitiveToAdapterType($this->primitives[$data['from']]);
            }
        }

        $to = null;
        if (isset($data['to'])) {

            if (isset($this->types[$data['to']])) {
                $to = $this->typeAdapter->fromTypeToAdapterType($this->types[$data['to']]);
            }

            if (isset($this->primitives[$data['to']])) {
                $to = $this->typeAdapter->fromPrimitiveToAdapterType($this->primitives[$data['to']]);
            }

        }

        return new ConcreteConverter($from, $to);

    }

}
