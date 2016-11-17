<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Client;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions\ClientException;

final class ConcreteClient implements Client {
    private $version;
    private $connectedBy;
    public function __construct($version, $connectedBy) {

        if (empty($version) || !is_string($version)) {
            throw new ClientException('The version must be a non-empty string.');
        }

        if (empty($connectedBy) || !is_string($connectedBy)) {
            throw new ClientException('The connectedBy must be a non-empty string.');
        }

        $this->version = $version;
        $this->connectedBy = $connectedBy;

    }

    public function getVersion() {
        return $this->version;
    }

    public function connectedBy() {
        return $this->connectedBy;
    }

}
