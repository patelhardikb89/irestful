<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Adapters\ForeignKeyAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Exceptions\ForeignKeyException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey;

final class ForeignKeyAdapterHelper {
    private $phpunit;
    private $foreignKeyAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ForeignKeyAdapter $foreignKeyAdapterMock) {
        $this->phpunit = $phpunit;
        $this->foreignKeyAdapterMock = $foreignKeyAdapterMock;
    }

    public function expectsFromDataToForeignKey_Success(ForeignKey $returnedForeignKey, array $data) {
        $this->foreignKeyAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToForeignKey')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue($returnedForeignKey));
    }

    public function expectsFromDataToForeignKey_returnsNull_Success(array $data) {
        $this->foreignKeyAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToForeignKey')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue(null));
    }

    public function expectsFromDataToForeignKey_throwsForeignKeyException(array $data) {
        $this->foreignKeyAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToForeignKey')
                                        ->with($data)
                                        ->will($this->phpunit->throwException(new ForeignKeyException('TEST')));
    }

}
