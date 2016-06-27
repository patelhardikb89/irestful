<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use  iRESTful\Rodson\Domain\Databases\RESTAPIs\RESTAPI;
use iRESTful\Rodson\Domain\Databases\RESTAPIs\Exceptions\RESTAPIException;
use iRESTful\Objects\Libraries\Credentials\Domain\Credentials;

final class ConcreteRESTAPI implements RESTAPI {
    private $baseUrl;
    private $port;
    private $credentials;
    private $token;
    public function __construct($baseUrl, $port, Credentials $credentials = null, $token = null) {

        if (empty($token)) {
            $token = null;
        }

        if (!empty($credentials) && !empty($token)) {
            throw new RESTAPIException('The credentials and token cannot be both non-empty.');
        }

        if (empty($baseUrl) || !is_string($baseUrl)) {
            throw new RESTAPIException('The baseUrl must be a non-empty string.');
        }

        if (!filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            throw new RESTAPIException('The baseUrl ('.$baseUrl.') is not a valid URL.');
        }

        if (!empty($token) && !is_string($token)) {
            throw new RESTAPIException('The token must be a string if non-empty.');
        }

        if (!is_integer($port)) {
            throw new RESTAPIException('The port must be an integer.');
        }

        $this->baseUrl = $baseUrl;
        $this->port = $port;
        $this->credentials = $credentials;
        $this->token = $token;

    }

    public function hasCredentials() {
        return !empty($this->credentials);
    }

    public function getCredentials() {
        return $this->credentials;
    }

    public function hasToken() {
        return !empty($this->token);
    }

    public function getToken() {
        return $this->token;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getPort() {
        return $this->port;
    }

}
