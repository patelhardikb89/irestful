<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteController;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Adapters\ViewAdapter;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $viewAdapter;
    public function __construct(ViewAdapter $viewAdapter) {
        $this->viewAdapter = $viewAdapter;
    }

    public function fromDataToControllers(array $data) {
        $output = [];
        foreach($data as $name => $oneData) {
            $oneData['name'] = $name;
            $output[$name] = $this->fromDataToController($oneData);
        }

        return $output;
    }

    public function fromDataToController(array $data) {

        if (!isset($data['name'])) {
            throw new ControllerException('The name is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['pattern'])) {
            throw new ControllerException('The pattern is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['view'])) {
            throw new ControllerException('The view is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['function'])) {
            throw new ControllerException('The function is mandatory in order to convert data to a Controller object.');
        }

        $view = (is_array($data['view']) ? $this->viewAdapter->fromDataToView($data['view']) : $this->viewAdapter->fromStringToView($data['view']));
        return new ConcreteController($data['name'], $data['pattern'], $view, $data['function']);
    }

}
