<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Command;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Views\View;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Exceptions\HttpRequestException;
use iRESTful\Rodson\DSLs\Domain\Projects\Values\Value;

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

    public function getCommand(): Command {
        return $this->command;
    }

    public function getView(): View {
        return $this->view;
    }

    public function hasQueryParameters(): bool {
        return !empty($this->queryParameters);
    }

    public function getQueryParameters() {
        return $this->queryParameters;
    }

    public function hasRequestParameters(): bool {
        return !empty($this->requestParameters);
    }

    public function getRequestParameters() {
        return $this->requestParameters;
    }

    public function hasHeaders(): bool {
        return !empty($this->headers);
    }

    public function getHeaders() {
        return $this->headers;
    }
}
