<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Adapters\ServerAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;

final class ServerAdapterHelper {
    private $phpunit;
    private $serverAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ServerAdapter $serverAdapterMock) {
        $this->phpunit = $phpunit;
        $this->serverAdapterMock = $serverAdapterMock;
    }

    public function expectsFromNativePDOToServer_Success(Server $returnedServer, NativePDO $pdo) {

        $this->serverAdapterMock->expects($this->phpunit->once())
                                ->method('fromNativePDOToServer')
                                ->with($pdo)
                                ->will($this->phpunit->returnValue($returnedServer));

    }

    public function expectsFromNativePDOToServer_throwsServerException(NativePDO $pdo) {

        $this->serverAdapterMock->expects($this->phpunit->once())
                                ->method('fromNativePDOToServer')
                                ->with($pdo)
                                ->will($this->phpunit->throwException(new ServerException('TEST')));

    }

}
