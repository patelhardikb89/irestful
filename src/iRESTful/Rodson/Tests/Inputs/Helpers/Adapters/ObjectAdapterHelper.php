<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Exceptions\ObjectException;

final class ObjectAdapterHelper {
    private $phpunit;
    private $objectAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ObjectAdapter $objectAdapterMock) {
        $this->phpunit = $phpunit;
        $this->objectAdapterMock = $objectAdapterMock;
    }

    public function expectsFromDataToObjects_Success(array $returnedObjects, array $data) {
        $this->objectAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToObjects')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedObjects));
    }

    public function expectsFromDataToObjects_multiple_Success(array $returnedObjects, array $data) {
        $amount = count($returnedObjects);
        $this->objectAdapterMock->expects($this->phpunit->exactly($amount))
                                ->method('fromDataToObjects')
                                ->with(call_user_func_array(array($this->phpunit, 'logicalOr'), $data))
                                ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedObjects));
    }

    public function expectsFromDataToObjects_throwsObjectException(array $data) {
        $this->objectAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToObjects')
                                ->with($data)
                                ->will($this->phpunit->throwException(new ObjectException('TEST')));
    }

}
