<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Url;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Exceptions\UrlException;

final class ConcreteControllerHttpRequestCommandUrl implements Url {
    private $baseUrl;
    private $endpoint;
    private $port;
    public function __construct($baseUrl, $endpoint, $port = null) {

        if (empty($port)) {
            $port = null;
        }

        if (empty($baseUrl) || !is_string($baseUrl)) {
            throw new UrlException('The baseUrl must be a non-empty string.');
        }

        if (empty($endpoint) || !is_string($endpoint)) {
            throw new UrlException('The endpoint must be a non-empty string.');
        }

        if (!empty($endpoint) && !is_int($port)) {
            throw new UrlException('The port must be an integer if non-empty.');
        }

        $this->baseUrl = $baseUrl;
        $this->endpoint = $endpoint;
        $this->port = $port;

    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getEndpoint() {
        return $this->endpoint;
    }

    public function hasPort() {
        return !empty($this->port);
    }

    public function getPort() {
        return $this->port;
    }

    public function getData() {
        $output = [
            'base_url' => $this->getBaseUrl(),
            'endpoint' => $this->getEndpoint()
        ];

        if ($this->hasPort()) {
            $output['port'] = $this->port;
        }

        return $output;
    }

}
