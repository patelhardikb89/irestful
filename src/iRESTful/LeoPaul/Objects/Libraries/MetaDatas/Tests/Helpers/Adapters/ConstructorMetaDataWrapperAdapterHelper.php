<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\Adapters\ConstructorMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Wrappers\ConstructorMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConstructorMetaDataWrapperAdapterHelper {
	private $phpunit;
	private $constructorMetaDataWrapperAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ConstructorMetaDataWrapperAdapter $constructorMetaDataWrapperAdapterMock) {
		$this->phpunit = $phpunit;
		$this->constructorMetaDataWrapperAdapterMock = $constructorMetaDataWrapperAdapterMock;
	}

	public function expectsFromDataToConstructorMetaDataWrapper_Success(ConstructorMetaDataWrapper $returnedConstructorMetaDataWrapper, array $data) {
		$this->constructorMetaDataWrapperAdapterMock->expects($this->phpunit->once())
													->method('fromDataToConstructorMetaDataWrapper')
													->with($data)
													->will($this->phpunit->returnValue($returnedConstructorMetaDataWrapper));
	}

	public function expectsFromDataToConstructorMetaDataWrapper_multiple_Success(array $returnedConstructorMetaDataWrappers, array $inputs) {

		foreach($returnedConstructorMetaDataWrappers as $index => $oneConstructorMetaDataWrapper) {
            $this->constructorMetaDataWrapperAdapterMock->expects($this->phpunit->at($index))
							                            ->method('fromDataToConstructorMetaDataWrapper')
														->with($inputs[$index])
							                            ->will($this->phpunit->returnValue($oneConstructorMetaDataWrapper));
        }
	}

	public function expectsFromDataToConstructorMetaDataWrapper_throwsConstructorMetaDataException(array $data) {
		$this->constructorMetaDataWrapperAdapterMock->expects($this->phpunit->once())
													->method('fromDataToConstructorMetaDataWrapper')
													->with($data)
													->will($this->phpunit->throwException(new ConstructorMetaDataException('TEST')));
	}

}
