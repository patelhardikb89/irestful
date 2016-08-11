<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Adapters\HttpRequestAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Adapters\CommandAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Views\Adapters\ViewAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteControllerHttpRequest;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Exceptions\HttpRequestException;

final class ConcreteControllerHttpRequestAdapter implements HttpRequestAdapter {
    private $commandAdapter;
    private $viewAdapter;
    private $valueAdapter;
    public function __construct(CommandAdapter $commandAdapter, ViewAdapter $viewAdapter, ValueAdapter $valueAdapter) {
        $this->commandAdapter = $commandAdapter;
        $this->viewAdapter = $viewAdapter;
        $this->valueAdapter = $valueAdapter;
    }

    public function fromDataToHttpRequests(array $data) {
        $output = [];
        foreach($data as $keyname => $oneData) {
            $output[$keyname] = $this->fromDataToHttpRequest($oneData);
        }

        return $output;
    }

    public function fromDataToHttpRequest(array $data) {

        if (!isset($data['command'])) {
            throw new HttpRequestException('The command keyname is mandatory in order to convert data to an HttpRequest object.');
        }

        if (!isset($data['view'])) {
            throw new HttpRequestException('The view keyname is mandatory in order to convert data to an HttpRequest object.');
        }

        $queryParameters = null;
        if (isset($data['parameters']['query'])) {
            $queryParameters = $this->valueAdapter->fromDataToValues($data['parameters']['query']);
        }

        $requestParameters = null;
        if (isset($data['parameters']['request'])) {
            $requestParameters = $this->valueAdapter->fromDataToValues($data['parameters']['request']);
        }

        $headers = null;
        if (isset($data['headers'])) {
            $headers = $this->valueAdapter->fromDataToValues($data['headers']);
        }

        $view = $this->viewAdapter->fromStringToView($data['view']);
        $command = $this->commandAdapter->fromStringToCommand($data['command']);
        return new ConcreteControllerHttpRequest($command, $view, $queryParameters, $requestParameters, $headers);
    }

}
