<?php
namespace iRESTful\Rodson\Tests\Outputs\Helpers\Objects;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\File;

final class FileHelper {
    private $phpunit;
    private $fileMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, File $fileMock) {
        $this->phpunit = $phpunit;
        $this->fileMock = $fileMock;
    }

    public function expectsGet_Success($returnedFile) {
        $this->fileMock->expects($this->phpunit->once())
                        ->method('get')
                        ->will($this->phpunit->returnValue($returnedFile));
    }

}
