<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData;

final class ArgumentMetaDataHelper {
	private $phpunit;
	private $argumentMetaDataMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArgumentMetaData $argumentMetaDataMock) {
		$this->phpunit = $phpunit;
		$this->argumentMetaDataMock = $argumentMetaDataMock;
	}

	public function expectsGetName_Success($returnedName) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('getName')
									->will($this->phpunit->returnValue($returnedName));
	}

	public function expectsGetPosition_Success($returnedPosition) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('getPosition')
									->will($this->phpunit->returnValue($returnedPosition));
	}

	public function expectsHasClassMetaData_Success($returnedBoolean) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('hasClassMetaData')
									->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsGetClassMetaData_Success(ClassMetaData $returnedClassMetaData) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('getClassMetaData')
									->will($this->phpunit->returnValue($returnedClassMetaData));
	}

	public function expectsIsOptional_Success($returnedBoolean) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('isOptional')
									->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsIsRecursive_Success($returnedBoolean) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('isRecursive')
									->will($this->phpunit->returnValue($returnedBoolean));
	}

    public function expectsHasArrayMetaData_Success($returnedBoolean) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('hasArrayMetaData')
									->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsGetArrayMetaData_Success(ArrayMetaData $returnedArrayMetaData) {
		$this->argumentMetaDataMock->expects($this->phpunit->once())
									->method('getArrayMetaData')
									->will($this->phpunit->returnValue($returnedArrayMetaData));
	}

}
