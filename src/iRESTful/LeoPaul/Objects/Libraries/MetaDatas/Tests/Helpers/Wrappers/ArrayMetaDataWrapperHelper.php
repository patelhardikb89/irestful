<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\ArrayMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ArrayMetaDataWrapperHelper {
	private $phpunit;
	private $arrayMetaDataWrapperMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArrayMetaDataWrapper $arrayMetaDataWrapperMock) {
		$this->phpunit = $phpunit;
		$this->arrayMetaDataWrapperMock = $arrayMetaDataWrapperMock;
	}

	public function expectsTransform_Success($returnedOutput, $input) {
		$this->arrayMetaDataWrapperMock->expects($this->phpunit->once())
										->method('transform')
										->with($input)
										->will($this->phpunit->returnValue($returnedOutput));
	}

	public function expectsTransform_throwsArrayMetaDataException($input) {
		$this->arrayMetaDataWrapperMock->expects($this->phpunit->once())
										->method('transform')
										->with($input)
										->will($this->phpunit->throwException(new ArrayMetaDataException('TEST')));
	}

}
