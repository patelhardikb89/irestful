<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Adapters\ConverterAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteConverter;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Adapters\MethodAdapter;

final class ConcreteConverterAdapter implements ConverterAdapter {
    private $methodAdapter;
    private $typeAdapter;
    private $types;
    private $primitives;
    public function __construct(MethodAdapter $methodAdapter, TypeAdapter $typeAdapter, array $types, array $primitives) {
        $this->methodAdapter = $methodAdapter;
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

        $getAdapterType = function($name) {
            if (isset($this->types[$name])) {
                return $this->typeAdapter->fromTypeToAdapterType($this->types[$name]);
            }

            if (isset($this->primitives[$name])) {
                return $this->typeAdapter->fromPrimitiveToAdapterType($this->primitives[$name]);
            }

            return $this->typeAdapter->fromStringToAdapterType($name);
        };

        $from = null;
        if (isset($data['from'])) {
            $from = $getAdapterType($data['from']);
        }

        $to = null;
        if (isset($data['to'])) {
            $to = $getAdapterType($data['to']);
        }

        $method = null;
        if (isset($data['method'])) {
            $method = $this->methodAdapter->fromDataToMethod([
                'name' => $data['method'],
                'method' => $data['method']
            ]);
        }

        $keyname = 'from_'.$data['from'].'_to_'.$data['to'];
        return new ConcreteConverter($keyname, $from, $to, $method);

    }

}
