<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\Adapters\ArgumentMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Wrappers\ArgumentMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ArgumentMetaDataWrapperAdapterHelper {
	private $phpunit;
	private $argumentMetaDataWrapperAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArgumentMetaDataWrapperAdapter $argumentMetaDataWrapperAdapterMock) {
		$this->phpunit = $phpunit;
		$this->argumentMetaDataWrapperAdapterMock = $argumentMetaDataWrapperAdapterMock;
	}

	public function expectsFromDataToArgumentMetaDataWrapper_Success(ArgumentMetaDataWrapper $returnedArgumentMetaDataWrapper, array $data) {

		$this->argumentMetaDataWrapperAdapterMock->expects($this->phpunit->once())
													->method('fromDataToArgumentMetaDataWrapper')
													->with($data)
													->will($this->phpunit->returnValue($returnedArgumentMetaDataWrapper));

	}

	public function expectsFromDataToArgumentMetaDataWrapper_throwsArgumentMetaDataException(array $data) {

		$this->argumentMetaDataWrapperAdapterMock->expects($this->phpunit->once())
													->method('fromDataToArgumentMetaDataWrapper')
													->with($data)
													->will($this->phpunit->throwException(new ArgumentMetaDataException('TEST')));

	}

}
