<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Factories\NativePDOFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Exceptions\NativePDOException;

final class NativePDOFactoryHelper {
    private $phpunit;
    private $nativePDOFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, NativePDOFactory $nativePDOFactoryMock) {
        $this->phpunit = $phpunit;
        $this->nativePDOFactoryMock = $nativePDOFactoryMock;
    }

    public function expectsCreate_Success(NativePDO $returnedNativePDO) {
        $this->nativePDOFactoryMock->expects($this->phpunit->once())
                                    ->method('create')
                                    ->will($this->phpunit->returnValue($returnedNativePDO));
    }

    public function expectsCreate_throwsNativePDOException() {
        $this->nativePDOFactoryMock->expects($this->phpunit->once())
                                    ->method('create')
                                    ->will($this->phpunit->throwException(new NativePDOException('TEST')));
    }

}
