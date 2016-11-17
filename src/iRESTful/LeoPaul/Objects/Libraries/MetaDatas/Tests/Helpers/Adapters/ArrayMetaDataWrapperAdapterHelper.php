<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\Adapters\ArrayMetaDataWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\ArrayMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ArrayMetaDataWrapperAdapterHelper {
	private $phpunit;
	private $arrayMetaDataWrapperAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArrayMetaDataWrapperAdapter $arrayMetaDataWrapperAdapterMock) {
		$this->phpunit = $phpunit;
		$this->arrayMetaDataWrapperAdapterMock = $arrayMetaDataWrapperAdapterMock;
	}

	public function expectsFromDataToArrayMetaDataWrappera_Success(ArrayMetaDataWrapper $returnedArrayMetaDataWrapper, array $data) {
		$this->arrayMetaDataWrapperAdapterMock->expects($this->phpunit->once())
												->method('fromDataToArrayMetaDataWrapper')
												->with($data)
												->will($this->phpunit->returnValue($returnedArrayMetaDataWrapper));
	}

	public function expectsFromDataToArrayMetaDataWrapper_throwsArrayMetaDataException(array $data) {
		$this->arrayMetaDataWrapperAdapterMock->expects($this->phpunit->once())
												->method('fromDataToArrayMetaDataWrapper')
												->with($data)
												->will($this->phpunit->throwException(new ArrayMetaDataException('TEST')));
	}

}
