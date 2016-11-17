<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Adapters\ClientAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Client;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions\ClientException;

final class ClientAdapterHelper {
    private $phpunit;
    private $clientAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ClientAdapter $clientAdapterMock) {
        $this->phpunit = $phpunit;
        $this->clientAdapterMock = $clientAdapterMock;
    }

    public function expectsFromNativePDOToClient_Success(Client $returnedClient, \PDO $pdo) {
        $this->clientAdapterMock->expects($this->phpunit->once())
                                ->method('fromNativePDOToClient')
                                ->with($pdo)
                                ->will($this->phpunit->returnValue($returnedClient));
    }

    public function expectsFromNativePDOToClient_throwsClientException(\PDO $pdo) {
        $this->clientAdapterMock->expects($this->phpunit->once())
                                ->method('fromNativePDOToClient')
                                ->with($pdo)
                                ->will($this->phpunit->throwException(new ClientException('TEST')));
    }

}
