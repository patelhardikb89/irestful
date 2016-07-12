<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

final class OutputMethodAdapterHelper {
    private $phpunit;
    private $methodAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, MethodAdapter $methodAdapterMock) {
        $this->phpunit = $phpunit;
        $this->methodAdapterMock = $methodAdapterMock;
    }

    public function expectsFromPropertiesToMethods_Success(array $returnedMethods, array $properties) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                    ->method('fromPropertiesToMethods')
                                    ->with($properties)
                                    ->will($this->phpunit->returnValue($returnedMethods));
    }

    public function expectsFromPropertiesToMethods_multiple_Success(array $returnedMethods, array $properties) {
        $amount = count($returnedMethods);
        $this->methodAdapterMock->expects($this->phpunit->exactly($amount))
                                ->method('fromPropertiesToMethods')
                                ->with(call_user_func_array(array($this->phpunit, 'logicalOr'), $properties))
                                ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedMethods));
    }

    public function expectsFromPropertiesToMethods_throwsMethodException(array $properties) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                    ->method('fromPropertiesToMethods')
                                    ->with($properties)
                                    ->will($this->phpunit->throwException(new MethodException('TEST')));
    }

    public function expectsFromDataToMethods_Success(array $returnedMethods, array $data) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToMethods')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedMethods));
    }

    public function expectsFromDataToMethods_throwsMethodException(array $data) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToMethods')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new MethodException('TEST')));
    }

    public function expectsFromTypeToMethods_Success(array $returnedMethods, Type $type) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                    ->method('fromTypeToMethods')
                                    ->with($type)
                                    ->will($this->phpunit->returnValue($returnedMethods));
    }

    public function expectsFromTypeToMethods_throwsMethodException(Type $type) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                    ->method('fromTypeToMethods')
                                    ->with($type)
                                    ->will($this->phpunit->throwException(new MethodException('TEST')));
    }

}
