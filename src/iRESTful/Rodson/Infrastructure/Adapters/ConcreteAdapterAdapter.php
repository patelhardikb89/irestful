<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Adapters\Adapters\AdapterAdapter;
use iRESTful\Rodson\Domain\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteAdapter;
use iRESTful\Rodson\Domain\Codes\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Adapters\Exceptions\AdapterException;

//must have keynames.  Have a look at the ConcreteTypeAdapter.
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
            $output[] = $this->fromDataToAdapter($oneData);
        }
        return $output;
    }

    public function fromDataToAdapter(array $data) {

        if (!isset($data['from'])) {
            throw new AdapterException('The from keyname is mandatory in order to convert data to an Adapter object.');
        }

        if (!isset($data['to'])) {
            throw new AdapterException('The to keyname is mandatory in order to convert data to an Adapter object.');
        }

        if (!isset($data['method'])) {
            throw new AdapterException('The method keyname is mandatory in order to convert data to an Adapter object.');
        }

        if (!isset($this->types[$data['from']])) {
            throw new AdapterException('The from type reference ('.$data['from'].') is invalid.');
        }

        if (!isset($this->types[$data['to']])) {
            throw new AdapterException('The to type reference ('.$data['to'].') is invalid.');
        }

        try {

            $from = $this->types[$data['from']];
            $to = $this->types[$data['to']];
            $method = $this->methodAdapter->fromStringToMethod($data['method']);
            return new ConcreteAdapter($from, $to, $method);

        } catch (MethodException $exception) {
            throw new AdapterException('There was an exception while converting a string to a Method object.', $exception);
        }

    }

}
