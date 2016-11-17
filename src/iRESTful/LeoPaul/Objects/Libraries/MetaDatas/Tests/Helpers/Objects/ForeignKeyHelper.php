<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table;

final class ForeignKeyHelper {
    private $phpunit;
    private $foreignKeyMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ForeignKey $foreignKeyMock) {
        $this->phpunit = $phpunit;
        $this->foreignKeyMock = $foreignKeyMock;
    }

    public function expectsHasTableReference_Success($returnedBoolean) {
        $this->foreignKeyMock->expects($this->phpunit->once())
                                ->method('hasTableReference')
                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsHasTableReference_multiple_Success(array $returnedBooleans) {
        $amount = count($returnedBooleans);
        $this->foreignKeyMock->expects($this->phpunit->exactly($amount))
                            ->method('hasTableReference')
                            ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedBooleans));
    }

    public function expectsGetTableReference_Success(Table $returnedTable) {
        $this->foreignKeyMock->expects($this->phpunit->once())
                                ->method('getTableReference')
                                ->will($this->phpunit->returnValue($returnedTable));
    }

    public function expectsHasMultiTableReference_multiple_Success(array $returnedBooleans) {
        $amount = count($returnedBooleans);
        $this->foreignKeyMock->expects($this->phpunit->exactly($amount))
                                ->method('hasMultiTableReference')
                                ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedBooleans));
    }

    public function expectsGetMultiTableReference_Success(Table $returnedTable) {
        $this->foreignKeyMock->expects($this->phpunit->once())
                                ->method('getMultiTableReference')
                                ->will($this->phpunit->returnValue($returnedTable));
    }

}
