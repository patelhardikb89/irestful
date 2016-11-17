<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;

final class NativePDOHelper {
    private $phpunit;
    private $nativePDOMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, NativePDO $nativePDOMock) {
        $this->phpunit = $phpunit;
        $this->nativePDOMock = $nativePDOMock;
    }

    public function expectsGetPDO_Success(\PDO $returnedPDO) {
        $this->nativePDOMock->expects($this->phpunit->once())
                            ->method('getPDO')
                            ->will($this->phpunit->returnValue($returnedPDO));
    }

    public function expectsGetDriver_Success($returnedDriver) {
        $this->nativePDOMock->expects($this->phpunit->once())
                            ->method('getDriver')
                            ->will($this->phpunit->returnValue($returnedDriver));
    }

    public function expectsGetHostName_Success($returnedHostName) {
        $this->nativePDOMock->expects($this->phpunit->once())
                            ->method('getHostName')
                            ->will($this->phpunit->returnValue($returnedHostName));
    }

    public function expectsGetUsername_Success($returnedUsername) {
        $this->nativePDOMock->expects($this->phpunit->once())
                            ->method('getUsername')
                            ->will($this->phpunit->returnValue($returnedUsername));
    }

    public function expectsGetDatabase_Success($returnedDatabase) {
        $this->nativePDOMock->expects($this->phpunit->once())
                            ->method('getDatabase')
                            ->will($this->phpunit->returnValue($returnedDatabase));
    }

}
