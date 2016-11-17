<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\ControllerRuleCriteria;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Exceptions\ControllerRuleCriteriaException;

final class ConcreteControllerRuleCriteria implements ControllerRuleCriteria {
    private $uri;
    private $method;
    private $port;
    private $queryParameters;
    public function __construct($uri, $method, $port = null, array $queryParameters = null) {

        if (empty($queryParameters)) {
            $queryParameters = null;
        }

        if (empty($port)) {
            $port = null;
        }

        if (!is_string($uri) || empty($uri)) {
            throw new ControllerRuleCriteriaException('The uri parameter must be a non-empty string that represents either an exact match or a regex pattern of the requested URI.');
        }

        if (!is_string($method) || empty($method)) {
            throw new ControllerRuleCriteriaException('The method parameter must be a non-empty string that represents either an exact match or a regex pattern of the requested HTTP Method.');
        }

        if (!empty($port) && !is_string($port) && !is_integer($port)) {
            throw new ControllerRuleCriteriaException('The port parameter must be a string/integer that represents either an exact match or a regex pattern of the requested port.');
        }

        if (!empty($queryParameters)) {

            foreach($queryParameters as $keyname => $oneQueryParameter) {

                if (!is_string($keyname)) {
                    throw new ControllerRuleCriteriaException('The keynames of the queryParameters must be strings that represents the exact mact of the requested queryParameters.');
                }

                if (!is_string($oneQueryParameter) && !is_numeric($oneQueryParameter)) {
                    throw new ControllerRuleCriteriaException('The values of the queryParameters must be strings/numeric values that either represents exact matches or a regex patterns of the query parameters.');
                }

            }

        }

        $this->uri = $uri;
        $this->method = strtolower($method);
        $this->port = $port;
        $this->queryParameters = $queryParameters;
    }

    public function getURI() {
        return $this->uri;
    }

    public function getMethod() {
        return $this->method;
    }

    public function hasPort() {
        return !empty($this->port);
    }

    public function getPort() {
        return $this->port;
    }

    public function hasQueryParameters() {
        return !empty($this->queryParameters);
    }

    public function getQueryParameters() {
        return $this->queryParameters;
    }

}
