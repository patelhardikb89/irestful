<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Adapters\ClientAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteClient;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions\ClientException;

final class ConcreteClientAdapter implements ClientAdapter {

    public function __construct() {

    }

    public function fromNativePDOToClient(\PDO $pdo) {

        try {

            $version = @$pdo->getAttribute(\PDO::ATTR_CLIENT_VERSION);
            $connectedBy = @$pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS);

            return new ConcreteClient($version, $connectedBy);

        } catch (\PDOException $exception) {
            throw new ClientException('There was an exception while using the \PDO driver.', $exception);
        }

    }

}
