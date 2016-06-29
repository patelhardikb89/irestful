<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteController;
use iRESTful\Rodson\Domain\Controllers\Exceptions\ControllerException;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $views;
    public function __construct(array $views) {
        $this->views = $views;
    }

    public function fromDataToControllers(array $data) {
        $output = [];
        foreach($data as $pattern => $oneData) {
            $oneData['pattern'] = $pattern;
            $output[] = $this->fromDataToController($oneData);
        }

        return $output;
    }

    public function fromDataToController(array $data) {

        if (!isset($data['pattern'])) {
            throw new ControllerException('The pattern is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['view'])) {
            throw new ControllerException('The view is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['instructions'])) {
            throw new ControllerException('The instructions is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($this->views[$data['view']])) {
            throw new ControllerException('The referenced view ('.$data['view'].') does not exist.');
        }

        $view = $this->views[$data['view']];
        return new ConcreteController($data['pattern'], $data['instructions'], $view);
    }

}
