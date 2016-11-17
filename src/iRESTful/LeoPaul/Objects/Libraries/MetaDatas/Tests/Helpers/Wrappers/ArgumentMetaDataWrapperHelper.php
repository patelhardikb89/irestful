<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ArgumentMetaDataWrapperHelper {
	private $phpunit;
	private $argumentMetaDataWrapperMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArgumentMetaDataWrapper $argumentMetaDataWrapperMock) {
		$this->phpunit = $phpunit;
		$this->argumentMetaDataWrapperMock = $argumentMetaDataWrapperMock;
	}

	public function expectsTransform_Success($returnedTransformedValue, $input) {

		$this->argumentMetaDataWrapperMock->expects($this->phpunit->once())
											->method('transform')
											->with($input)
											->will($this->phpunit->returnValue($returnedTransformedValue));

	}

	public function expectsTransform_throwsArgumentMetaDataException($input) {

		$this->argumentMetaDataWrapperMock->expects($this->phpunit->once())
											->method('transform')
											->with($input)
											->will($this->phpunit->throwException(new ArgumentMetaDataException('TEST')));

	}

}
