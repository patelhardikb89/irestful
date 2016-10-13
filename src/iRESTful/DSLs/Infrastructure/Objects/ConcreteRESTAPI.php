<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\RESTAPI;
use iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\Exceptions\RESTAPIException;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Credentials;
use iRESTful\DSLs\Domain\URLs\Url;

final class ConcreteRESTAPI implements RESTAPI {
    private $baseUrl;
    private $port;
    private $credentials;
    private $headerLine;
    public function __construct(Url $baseUrl, int $port, Credentials $credentials = null, string $headerLine = null) {

        if (empty($headerLine)) {
            $headerLine = null;
        }

        if (!empty($credentials) && !empty($headerLine)) {
            throw new RESTAPIException('The credentials and headerLine cannot be both non-empty.');
        }

        $this->baseUrl = $baseUrl;
        $this->port = $port;
        $this->credentials = $credentials;
        $this->headerLine = $headerLine;

    }

    public function hasCredentials(): bool {
        return !empty($this->credentials);
    }

    public function getCredentials() {
        return $this->credentials;
    }

    public function hasHeaderLine(): bool {
        return !empty($this->headerLine);
    }

    public function getHeaderLine() {
        return $this->headerLine;
    }

    public function getBaseUrl(): Url {
        return $this->baseUrl;
    }

    public function getPort(): int {
        return $this->port;
    }

}
