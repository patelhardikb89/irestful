<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server;

final class PDOHelper {
    private $phpunit;
    private $pdoMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDO $pdoMock) {
        $this->phpunit = $phpunit;
        $this->pdoMock = $pdoMock;
    }

    public function expectshasRequest_Success($returnedBoolean) {
        $this->pdoMock->expects($this->phpunit->once())
                        ->method('hasRequest')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetRequest_Success(Request $returnedRequest) {
        $this->pdoMock->expects($this->phpunit->once())
                        ->method('getRequest')
                        ->will($this->phpunit->returnValue($returnedRequest));
    }

    public function expectshasRequests_Success($returnedBoolean) {
        $this->pdoMock->expects($this->phpunit->once())
                        ->method('hasRequests')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetRequests_Success(array $returnedRequests) {
        $this->pdoMock->expects($this->phpunit->once())
                        ->method('getRequests')
                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsGetMicroDateTimeClosure_Success(MicroDateTimeClosure $returnedMicroDataClosure) {
        $this->pdoMock->expects($this->phpunit->once())
                        ->method('getMicroDateTimeClosure')
                        ->will($this->phpunit->returnValue($returnedMicroDataClosure));
    }

    public function expectsGetServer_Success(Server $returnedServer) {
        $this->pdoMock->expects($this->phpunit->once())
                        ->method('getServer')
                        ->will($this->phpunit->returnValue($returnedServer));
    }

}
