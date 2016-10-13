<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Adapters\HttpRequestAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Adapters\CommandAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Views\Adapters\ViewAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequest;
use iRESTful\DSLs\Domain\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Exceptions\HttpRequestException;

final class ConcreteControllerHttpRequestAdapter implements HttpRequestAdapter {
    private $commandAdapter;
    private $viewAdapter;
    private $valueAdapterAdapter;
    public function __construct(CommandAdapter $commandAdapter, ViewAdapter $viewAdapter, ValueAdapterAdapter $valueAdapterAdapter) {
        $this->commandAdapter = $commandAdapter;
        $this->viewAdapter = $viewAdapter;
        $this->valueAdapterAdapter = $valueAdapterAdapter;
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

        if (!isset($data['constants'])) {
            throw new HttpRequestException('The constants keyname is mandatory in order to convert data to an HttpRequest object.');
        }

        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter($data['constants']);

        $queryParameters = null;
        if (isset($data['parameters']['query'])) {
            $queryParameters = $valueAdapter->fromDataToValues($data['parameters']['query']);
        }

        $requestParameters = null;
        if (isset($data['parameters']['request'])) {
            $requestParameters = $valueAdapter->fromDataToValues($data['parameters']['request']);
        }

        $headers = null;
        if (isset($data['headers'])) {
            $headers = $valueAdapter->fromDataToValues($data['headers']);
        }

        $view = $this->viewAdapter->fromStringToView($data['view']);
        $command = $this->commandAdapter->fromStringToCommand($data['command']);
        return new ConcreteControllerHttpRequest($command, $view, $queryParameters, $requestParameters, $headers);
    }

}
