<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapters\AdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Adapters\Exceptions\AdapterException;

final class ConcreteAdapterAdapter implements AdapterAdapter {
    private $methodAdapter;
    private $types;
    public function __construct(MethodAdapter $methodAdapter, array $types) {
        $this->methodAdapter = $methodAdapter;
        $this->types = $types;
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
        if (isset($data['from']) && isset($this->types[$data['from']])) {
            $from = $this->types[$data['from']];
        }

        $to = null;
        if (isset($data['to']) && isset($this->types[$data['to']])) {
            $to = $this->types[$data['to']];
        }

        try {

            $method = $this->methodAdapter->fromStringToMethod($data['method']);
            return new ConcreteAdapter($method, $from, $to);

        } catch (MethodException $exception) {
            throw new AdapterException('There was an exception while converting a string to a Method object.', $exception);
        }

    }

}
