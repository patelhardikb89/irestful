<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Factories\ServerFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;

final class ServerFactoryHelper {
    private $phpunit;
    private $serverFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ServerFactory $serverFactoryMock) {
        $this->phpunit = $phpunit;
        $this->serverFactoryMock = $serverFactoryMock;
    }

    public function expectsCreate_Success(Server $returnedServer) {
        $this->serverFactoryMock->expects($this->phpunit->once())
                                    ->method('create')
                                    ->will($this->phpunit->returnValue($returnedServer));

    }

    public function expectsCreate_throwsServerException() {
        $this->serverFactoryMock->expects($this->phpunit->once())
                                    ->method('create')
                                    ->will($this->phpunit->throwException(new ServerException('TEST')));

    }

}
