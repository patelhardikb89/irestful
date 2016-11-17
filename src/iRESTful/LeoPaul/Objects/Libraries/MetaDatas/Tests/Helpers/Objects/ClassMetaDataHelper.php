<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;

final class ClassMetaDataHelper {
	private $phpunit;
	private $classMetaDataMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ClassMetaData $classMetaDataMock) {
		$this->phpunit = $phpunit;
		$this->classMetaDataMock = $classMetaDataMock;
	}

	public function expectsGetType_Success($returnedType) {
		$this->classMetaDataMock->expects($this->phpunit->once())
									->method('getType')
									->will($this->phpunit->returnValue($returnedType));
	}

	public function expectsGetArguments_Success(array $returnedArguments) {
		$this->classMetaDataMock->expects($this->phpunit->once())
									->method('getArguments')
									->will($this->phpunit->returnValue($returnedArguments));
	}

	public function expectsHasContainerName_Success($returnedBoolean) {
		$this->classMetaDataMock->expects($this->phpunit->once())
									->method('hasContainerName')
									->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsGetContainerName_Success($returnedContainerName) {
		$this->classMetaDataMock->expects($this->phpunit->once())
									->method('getContainerName')
									->will($this->phpunit->returnValue($returnedContainerName));
	}

}
