<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapters\AdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Adapters\Exceptions\AdapterException;
use iRESTful\Rodson\Domain\Inputs\Adapters\Types\Adapters\TypeAdapter;

final class ConcreteAdapterAdapter implements AdapterAdapter {
    private $typeAdapter;
    private $methodAdapter;
    private $types;
    private $primitives;
    public function __construct(TypeAdapter $typeAdapter, MethodAdapter $methodAdapter, array $types, array $primitives) {
        $this->typeAdapter = $typeAdapter;
        $this->methodAdapter = $methodAdapter;
        $this->types = $types;
        $this->primitives = $primitives;
    }

    public function fromDataToAdapters(array $data) {
        $output = [];
        foreach($data as $oneData) {

            if (!isset($oneData['from']) || !is_string($oneData['from'])) {
                throw new AdapterException('The data must contain from keynames.  The from keyname must also contain a string.');
            }

            if (!isset($oneData['to']) || !is_string($oneData['to'])) {
                throw new AdapterException('The data must contain to keynames.  The to keyname must also contain a string.');
            }

            $keyname = 'from_'.$oneData['from'].'_to_'.$oneData['to'];
            $output[$keyname] = $this->fromDataToAdapter($oneData);
        }

        return $output;
    }

    public function fromDataToAdapter(array $data) {

        if (!isset($data['method'])) {
            throw new AdapterException('The method keyname is mandatory in order to convert data to an Adapter object.');
        }

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

        try {

            $method = $this->methodAdapter->fromStringToMethod($data['method']);
            return new ConcreteAdapter($method, $from, $to);

        } catch (MethodException $exception) {
            throw new AdapterException('There was an exception while converting a string to a Method object.', $exception);
        }

    }

}
