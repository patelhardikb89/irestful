<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Url as HttpRequestCommandUrl;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Exceptions\UrlException;
use iRESTful\DSLs\Domain\URLs\Url;

final class ConcreteControllerHttpRequestCommandUrl implements HttpRequestCommandUrl {
    private $baseUrl;
    private $endpoint;
    private $port;
    public function __construct(Url $baseUrl, string $endpoint, int $port = null) {

        if (empty($port)) {
            $port = null;
        }

        if (empty($endpoint)) {
            throw new UrlException('The endpoint must be a non-empty string.');
        }

        if (strpos($endpoint, '/') !== 0) {
            throw new UrlException('The endpoint ('.$endpoint.') must begin with a slash (/).');
        }

        if (strrpos($endpoint, '/') === (strlen($endpoint) - 1)) {
            throw new UrlException('The endpoint ('.$endpoint.') must NOT end with a slash (/).');
        }

        $this->baseUrl = $baseUrl;
        $this->endpoint = $endpoint;
        $this->port = $port;

    }

    public function getBaseUrl(): Url {
        return $this->baseUrl;
    }

    public function getEndpoint(): string {
        return $this->endpoint;
    }

    public function hasPort(): bool {
        return !empty($this->port);
    }

    public function getPort() {
        return $this->port;
    }

}
