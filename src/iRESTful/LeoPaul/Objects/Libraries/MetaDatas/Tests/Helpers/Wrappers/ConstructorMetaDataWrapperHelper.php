<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\ConstructorMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConstructorMetaDataWrapperHelper {
	private $phpunit;
	private $constructorMetaDataWrapperMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ConstructorMetaDataWrapper $constructorMetaDataWrapperMock) {
		$this->phpunit = $phpunit;
		$this->constructorMetaDataWrapperMock = $constructorMetaDataWrapperMock;
	}

	public function expectsTransform_Success($returnedTransformedObject, array $input) {
		$this->constructorMetaDataWrapperMock->expects($this->phpunit->once())
												->method('transform')
												->with($input)
												->will($this->phpunit->returnValue($returnedTransformedObject));
	}

	public function expectsTransform_multiple_Success(array $returnedTransformedObjects, array $inputs) {

		$inputKeys = array_keys($inputs);
		foreach($returnedTransformedObjects as $index => $oneReturnedTransformedObject) {
            $this->constructorMetaDataWrapperMock->expects($this->phpunit->at($index))
						                            ->method('transform')
													->with($inputs[$inputKeys[$index]])
						                            ->will($this->phpunit->returnValue($oneReturnedTransformedObject));
        }
	}

	public function expectsTransform_throwsConstructorMetaDataException(array $input) {
		$this->constructorMetaDataWrapperMock->expects($this->phpunit->once())
												->method('transform')
												->with($input)
												->will($this->phpunit->throwException(new ConstructorMetaDataException('TEST')));
	}

}
