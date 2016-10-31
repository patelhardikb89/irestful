<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\Adapters\ControllerAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteController;
use iRESTful\DSLs\Domain\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Adapters\ViewAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Adapters\HttpRequestAdapter;

final class ConcreteControllerAdapter implements ControllerAdapter {
    private $viewAdapter;
    private $httpRequestAdapter;
    public function __construct(ViewAdapter $viewAdapter, HttpRequestAdapter $httpRequestAdapter) {
        $this->viewAdapter = $viewAdapter;
        $this->httpRequestAdapter = $httpRequestAdapter;
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

        $tests = [];
        if (isset($data['tests'])) {
            $tests = $data['tests'];
        }

        $constants = null;
        if (isset($data['constants'])) {
            $constants = $data['constants'];
        }

        $httpRequests = null;
        if (isset($data['http_requests'])) {
            $data['http_requests']['constants'] = $constants;
            $httpRequests = $this->httpRequestAdapter->fromDataToHttpRequests($data['http_requests']);
        }

        $view = (is_array($data['view']) ? $this->viewAdapter->fromDataToView($data['view']) : $this->viewAdapter->fromStringToView($data['view']));
        return new ConcreteController(
            $data['name'],
            $data['input'],
            $data['pattern'],
            $data['instructions'],
            $view,
            $tests,
            $constants,
            $httpRequests
        );
    }

}
