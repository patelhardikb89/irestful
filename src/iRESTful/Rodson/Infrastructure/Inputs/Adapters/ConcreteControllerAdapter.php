<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteController;
use iRESTful\Rodson\Domain\Inputs\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Domain\Inputs\Controllers\Views\Adapters\ViewAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Adapters\Adapters\HttpRequestAdapterAdapter;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $viewAdapter;
    private $httpRequestAdapterAdapter;
    public function __construct(ViewAdapter $viewAdapter, HttpRequestAdapterAdapter $httpRequestAdapterAdapter) {
        $this->viewAdapter = $viewAdapter;
        $this->httpRequestAdapterAdapter = $httpRequestAdapterAdapter;
    }

    public function fromDataToControllers(array $data) {
        $output = [];
        foreach($data as $name => $oneData) {
            $oneData['name'] = $name;
            $output[] = $this->fromDataToController($oneData);
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

        if (!isset($data['input'])) {
            throw new ControllerException('The input is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['view'])) {
            throw new ControllerException('The view is mandatory in order to convert data to a Controller object.');
        }

        if (!isset($data['instructions'])) {
            throw new ControllerException('The instructions is mandatory in order to convert data to a Controller object.');
        }

        $constants = null;
        if (isset($data['constants'])) {
            $constants = $data['constants'];
        }

        $httpRequests = null;
        if (isset($data['http_requests'])) {
            $httpRequests = $this->httpRequestAdapterAdapter->fromDataToHttpRequestAdapter([
                'constants' => $constants
            ])->fromDataToHttpRequests($data['http_requests']);
        }

        $view = (is_array($data['view']) ? $this->viewAdapter->fromDataToView($data['view']) : $this->viewAdapter->fromStringToView($data['view']));
        return new ConcreteController($data['name'], $data['input'], $data['pattern'], $data['instructions'], $view, $constants, $httpRequests);
    }

}
