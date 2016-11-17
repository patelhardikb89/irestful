<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Adapters\ArrayMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ArrayMetaDataAdapterHelper {
	private $phpunit;
	private $arrayMetaDataAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArrayMetaDataAdapter $arrayMetaDataAdapterMock) {
		$this->phpunit = $phpunit;
		$this->arrayMetaDataAdapterMock = $arrayMetaDataAdapterMock;
	}

	public function expectsFromDataToArrayMetaData_Success(ArrayMetaData $returnedArrayMetaData, array $data) {
		$this->arrayMetaDataAdapterMock->expects($this->phpunit->once())
										->method('fromDataToArrayMetaData')
										->with($data)
										->will($this->phpunit->returnValue($returnedArrayMetaData));
	}

	public function expectsfFromDataToArrayMetaData_multiple_Success(array $returnedArrayMetaDatas, array $data) {
		foreach($returnedArrayMetaDatas as $index => $oneArrayMetaData) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('fromDataToArrayMetaData')
							->with($data[$index])
                            ->will($this->phpunit->returnValue($oneArrayMetaData));
        }
	}

	public function expectsfFromDataToArrayMetaData_throwsArrayMetaDataException(array $data) {
		$this->arrayMetaDataAdapterMock->expects($this->phpunit->once())
										->method('fromDataToArrayMetaData')
										->with($data)
										->will($this->phpunit->throwException(new ArrayMetaDataException('TEST')));
	}

}
