<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Exceptions\NamespaceException;

final class NamespaceAdapterHelper {
    private $phpunit;
    private $namespaceAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, NamespaceAdapter $namespaceAdapterMock) {
        $this->phpunit = $phpunit;
        $this->namespaceAdapterMock = $namespaceAdapterMock;
    }

    public function expectsFromDataToNamespace_Success(ObjectNamespace $returnedNamespace, array $data) {
        $this->namespaceAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToNamespace')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedNamespace));
    }

    public function expectsFromDataToNamespace_multiple_Success(array $returnedNamespaces, array $data) {
        $amount = count($returnedNamespaces);
        $this->namespaceAdapterMock->expects($this->phpunit->exactly($amount))
                                    ->method('fromDataToNamespace')
                                    ->with(call_user_func_array(array($this->phpunit, 'logicalOr'), $data))
                                    ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedNamespaces));
    }

    public function expectsFromDataToNamespace_throwsNamespaceException(array $data) {
        $this->namespaceAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToNamespace')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new NamespaceException('TEST')));
    }

}
