<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\HttpRequest;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Command;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Views\View;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Exceptions\HttpRequestException;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Value;

final class ConcreteControllerHttpRequest implements HttpRequest {
    private $command;
    private $view;
    private $queryParameters;
    private $requestParameters;
    private $headers;
    public function __construct(
        Command $command,
        View $view,
        array $queryParameters = null,
        array $requestParameters = null,
        array $headers = null
    ) {

        if (empty($queryParameters)) {
            $queryParameters = null;
        }

        if (empty($requestParameters)) {
            $requestParameters = null;
        }

        if (empty($headers)) {
            $headers = null;
        }

        $validate = function(array $data, $variableName) {

            if (empty($data)) {
                return;
            }

            foreach($data as $keyname => $element) {
                if (!is_string($keyname)) {
                    throw new HttpRequestException('The '.$variableName.' array keynames must be strings.');
                }

                if (!($element instanceof Value)) {
                    throw new HttpRequestException('The '.$variableName.' array must only contain Value objects.');
                }
            }
        };

        if (!empty($queryParameters)) {
            $validate($queryParameters, 'queryParameters');
        }

        if (!empty($requestParameters)) {
            $validate($requestParameters, 'requestParameters');
        }

        if (!empty($headers)) {
            $validate($headers, 'headers');
        }

        $this->command = $command;
        $this->view = $view;
        $this->queryParameters = $queryParameters;
        $this->requestParameters = $requestParameters;
        $this->headers = $headers;

    }

    public function getCommand() {
        return $this->command;
    }

    public function getView() {
        return $this->view;
    }

    public function hasQueryParameters() {
        return !empty($this->queryParameters);
    }

    public function getQueryParameters() {
        return $this->queryParameters;
    }

    public function hasRequestParameters() {
        return !empty($this->requestParameters);
    }

    public function getRequestParameters() {
        return $this->requestParameters;
    }

    public function hasHeaders() {
        return !empty($this->headers);
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getData() {
        $output = [
            'command' => $this->getCommand()->getData(),
            'view' => $this->view->getData()
        ];

        if ($this->hasQueryParameters()) {
            $queryParameters = $this->getQueryParameters();
            array_walk($queryParameters, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['query_parameters'] = $queryParameters;
        }

        if ($this->hasRequestParameters()) {
            $requestParameters = $this->getRequestParameters();
            array_walk($requestParameters, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['request_parameters'] = $requestParameters;
        }

        if ($this->hasHeaders()) {
            $headers = $this->getHeaders();
            array_walk($headers, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['headers'] = $headers;
        }

        return $output;
    }

}
