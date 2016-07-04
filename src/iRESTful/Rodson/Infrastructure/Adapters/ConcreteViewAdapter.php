<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Views\Adapters\ViewAdapter;
use iRESTful\Rodson\Domain\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteView;
use iRESTful\Rodson\Domain\Views\Exceptions\ViewException;
use iRESTful\Rodson\Domain\Codes\Methods\Exceptions\MethodException;

final class ConcreteViewAdapter implements ViewAdapter {
    private $methodAdapter;
    public function __construct(MethodAdapter $methodAdapter) {
        $this->methodAdapter = $methodAdapter;
    }

    public function fromDataToViews(array $data) {
        $output = [];
        foreach($data as $name => $oneMethod) {
            $output[$name] = $this->fromDataToView([
                'name' => $name,
                'method' => $oneMethod
            ]);
        }

        return $output;
    }

    public function fromDataToView(array $data) {

        if (!isset($data['name'])) {
            throw new ViewException('The name keyname is mandatory in order to convert data to a View object.');
        }

        if (!isset($data['method'])) {
            throw new ViewException('The method keyname is mandatory in order to convert data to a View object.');
        }

        try {

            $method = $this->methodAdapter->fromStringToMethod($data['method']);
            return new ConcreteView($data['name'], $method);

        } catch (MethodException $exception) {
            throw new ViewException('There was an exception while converting a string to a Method object.', $exception);
        }

    }

}
