<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Adapters\ServerAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteServer;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Adapters\ClientAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions\ClientException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;

final class ConcreteServerAdapter implements ServerAdapter {
    private $clientAdapter;
    public function __construct(ClientAdapter $clientAdapter) {
        $this->clientAdapter = $clientAdapter;
    }

    public function fromNativePDOToServer(NativePDO $nativePDO) {

        try {

            $pdo = $nativePDO->getPDO();
            $hostName = $nativePDO->getHostName();
            $database = $nativePDO->getDatabase();
            $username = $nativePDO->getUsername();
            $driver = $nativePDO->getDriver();

            $client = $this->clientAdapter->fromNativePDOToClient($pdo);

            $stats =  @$pdo->getAttribute(\PDO::ATTR_SERVER_INFO);
            $version =  @$pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);
            $isPersistent = (bool) @$pdo->getAttribute(\PDO::ATTR_PERSISTENT);
            $isAutoCommit = (bool) @$pdo->getAttribute(\PDO::ATTR_AUTOCOMMIT);

            return new ConcreteServer($client, $driver, $hostName, $database, $username, $stats, $version, $isPersistent, $isAutoCommit);

        } catch (ClientException $exception) {
            throw new ServerException('There was an exception while converting a \PDO driver to a Client object.', $exception);
        } catch (\PDOException $exception) {
            throw new ServerException('There was an exception while using the \PDO driver.', $exception);
        }

    }

}
