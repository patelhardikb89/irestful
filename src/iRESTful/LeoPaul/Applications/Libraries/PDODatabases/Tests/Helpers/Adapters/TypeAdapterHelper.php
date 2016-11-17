<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Types\Adapters\TypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class TypeAdapterHelper {
    private $phpunit;
    private $typeAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, TypeAdapter $typeAdapterMock) {
        $this->phpunit = $phpunit;
        $this->typeAdapterMock = $typeAdapterMock;
    }

    public function expectsFromTypeToTypeInSqlQueryLine_Success($returnedTypeInSqlQuery, Type $type) {
        $this->typeAdapterMock->expects($this->phpunit->once())
                                ->method('fromTypeToTypeInSqlQueryLine')
                                ->with($type)
                                ->will($this->phpunit->returnValue($returnedTypeInSqlQuery));
    }

    public function expectsFromTypeToTypeInSqlQueryLine_multiple_Success(array $returnedTypeInSqlQueries, array $types) {
        $amount = count($returnedTypeInSqlQueries);
        $this->typeAdapterMock->expects($this->phpunit->exactly($amount))
                                ->method('fromTypeToTypeInSqlQueryLine')
                                ->with(call_user_func_array(array($this->phpunit, 'logicalOr'), $types))
                                ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedTypeInSqlQueries));
    }

    public function expectsFromTypeToTypeInSqlQueryLine_throwsTypeException(Type $type) {
        $this->typeAdapterMock->expects($this->phpunit->once())
                                ->method('fromTypeToTypeInSqlQueryLine')
                                ->with($type)
                                ->will($this->phpunit->throwException(new TypeException('TEST')));
    }

}
