<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Adapters\BinaryAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Binary;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Exceptions\BinaryException;

final class BinaryAdapterHelper {
    private $phpunit;
    private $binaryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, BinaryAdapter $binaryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->binaryAdapterMock = $binaryAdapterMock;
    }

    public function expectsFromDataToBinary_Success(Binary $returnedBinary, array $data) {
        $this->binaryAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToBinary')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedBinary));
    }

    public function expectsFromDataToBinary_throwsBinaryException(array $data) {
        $this->binaryAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToBinary')
                                ->with($data)
                                ->will($this->phpunit->throwException(new BinaryException('TEST')));
    }

}
