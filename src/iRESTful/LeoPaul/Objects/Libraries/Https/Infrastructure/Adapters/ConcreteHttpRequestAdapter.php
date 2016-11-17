<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects\ConcreteHttpRequest;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRequestAdapter implements HttpRequestAdapter {

    public function __construct() {

    }

    public function fromDataToHttpRequest(array $data) {

        if (!isset($data['uri'])) {
            throw new HttpException('The uri index is mandatory in order to convert data to an HttpRequest object.');
        }

        if (!isset($data['method'])) {
            throw new HttpException('The method index is mandatory in order to convert data to an HttpRequest object.');
        }

        if (!isset($data['port'])) {
            throw new HttpException('The port index is mandatory in order to convert data to an HttpRequest object.');
        }

        $queryParameters = (isset($data['query_parameters'])) ? $data['query_parameters'] : null;
        $requestParameters = (isset($data['request_parameters'])) ? $data['request_parameters'] : null;
        $headers = (isset($data['headers'])) ? $data['headers'] : null;
        $file = (isset($data['file'])) ? $data['file'] : null;

        return new ConcreteHttpRequest($data['uri'], $data['method'], $data['port'], $queryParameters, $requestParameters, $headers, $file);

    }

}
