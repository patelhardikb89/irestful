<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\RESTAPIs\RESTAPI;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\RESTAPIs\Exceptions\RESTAPIException;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Credentials\Credentials;

final class ConcreteRESTAPI implements RESTAPI {
    private $baseUrl;
    private $port;
    private $credentials;
    private $headerLine;
    public function __construct($baseUrl, $port, Credentials $credentials = null, $headerLine = null) {

        if (empty($headerLine)) {
            $headerLine = null;
        }

        if (!empty($credentials) && !empty($headerLine)) {
            throw new RESTAPIException('The credentials and headerLine cannot be both non-empty.');
        }

        if (empty($baseUrl) || !is_string($baseUrl)) {
            throw new RESTAPIException('The baseUrl must be a non-empty string.');
        }

        if (!filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            throw new RESTAPIException('The baseUrl ('.$baseUrl.') is not a valid URL.');
        }

        if (!empty($headerLine) && !is_string($headerLine)) {
            throw new RESTAPIException('The headerLine must be a string if non-empty.');
        }

        if (!is_integer($port)) {
            throw new RESTAPIException('The port must be an integer.');
        }

        $this->baseUrl = $baseUrl;
        $this->port = $port;
        $this->credentials = $credentials;
        $this->headerLine = $headerLine;

    }

    public function hasCredentials() {
        return !empty($this->credentials);
    }

    public function getCredentials() {
        return $this->credentials;
    }

    public function hasHeaderLine() {
        return !empty($this->headerLine);
    }

    public function getHeaderLine() {
        return $this->headerLine;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getPort() {
        return $this->port;
    }

    public function getData() {
        $output = [
            'base_url' => $this->baseUrl,
            'port' => $this->port
        ];

        if ($this->hasCredentials()) {
            $output['credentials'] = $this->credentials->getData();
        }

        if ($this->hasHeaderLine()) {
            $output['header_line'] = $this->headerLine;
        }

        return $output;
    }

}
