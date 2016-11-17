<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters\KeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;

final class KeynameAdapterHelper {
    private $phpunit;
    private $keynameAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, KeynameAdapter $keynameAdapterMock) {
        $this->phpunit = $phpunit;
        $this->keynameAdapterMock = $keynameAdapterMock;
    }

    public function expectsFromDataToKeyname_Success(Keyname $returnedKeyname, array $data) {
        $this->keynameAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToKeyname')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedKeyname));
    }

    public function expectsFromDataToKeyname_throwsKeynameException(array $data) {
        $this->keynameAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToKeyname')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new KeynameException('TEST')));
    }

    public function expectsFromDataToKeynames_Success(array $returnedKeynames, array $data) {
        $this->keynameAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToKeynames')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedKeynames));
    }

    public function expectsFromDataToKeynames_throwsKeynameException(array $data) {
        $this->keynameAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToKeynames')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new KeynameException('TEST')));
    }

}
