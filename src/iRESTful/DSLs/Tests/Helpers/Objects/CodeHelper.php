<?php
namespace iRESTful\DSLs\Tests\Helpers\Objects;
use iRESTful\DSLs\Domain\Projects\Codes\Code;

final class CodeHelper {
    private $phpunit;
    private $codeMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Code $codeMock) {
        $this->phpunit = $phpunit;
        $this->codeMock = $codeMock;
    }

    public function expectsGetClassName_Success($returnedClassName) {
        $this->codeMock->expects($this->phpunit->once())
                        ->method('getClassName')
                        ->will($this->phpunit->returnValue($returnedClassName));
    }

}
