<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Adapters\ConstructorMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConstructorMetaDataAdapterHelper {
	private $phpunit;
	private $constructorMetaDataAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ConstructorMetaDataAdapter $constructorMetaDataAdapterMock) {
		$this->phpunit = $phpunit;
		$this->constructorMetaDataAdapterMock = $constructorMetaDataAdapterMock;
	}

	public function expectsFromDataToConstructorMetaData_Success(ConstructorMetaData $returnedConstructorMetaData, array $data) {
		$this->constructorMetaDataAdapterMock->expects($this->phpunit->once())
												->method('fromDataToConstructorMetaData')
												->with($data)
												->will($this->phpunit->returnValue($returnedConstructorMetaData));
	}

	public function expectsFromDataToConstructorMetaData_multiple_Success(array $returnedConstructorMetaDatas, array $data) {
		foreach($returnedConstructorMetaDatas as $index => $oneConstructorMetaData) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('fromDataToConstructorMetaData')
							->with($data[$index])
                            ->will($this->phpunit->returnValue($oneConstructorMetaData));
        }
	}

	public function expectsFromDataToConstructorMetaData_throwsConstructorMetaDataException(array $data) {
		$this->constructorMetaDataAdapterMock->expects($this->phpunit->once())
												->method('fromDataToConstructorMetaData')
												->with($data)
												->will($this->phpunit->throwException(new ConstructorMetaDataException('TEST')));
	}

	public function expectsFromDataToConstructorMetaDatas_Success(array $returnedConstructorMetaDatas, array $data) {
		$this->constructorMetaDataAdapterMock->expects($this->phpunit->once())
												->method('fromDataToConstructorMetaDatas')
												->with($data)
												->will($this->phpunit->returnValue($returnedConstructorMetaDatas));
	}

	public function expectsFromDataToConstructorMetaDatas_multiple_Success(array $returnedConstructorMetaDatas, array $data) {
		foreach($returnedConstructorMetaDatas as $index => $oneConstructorMetaDatas) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('fromDataToConstructorMetaDatas')
							->with($data[$index])
                            ->will($this->phpunit->returnValue($oneConstructorMetaDatas));
        }
	}

	public function expectsFromDataToConstructorMetaDatas_throwsConstructorMetaDataException(array $data) {
		$this->constructorMetaDataAdapterMock->expects($this->phpunit->once())
												->method('fromDataToConstructorMetaDatas')
												->with($data)
												->will($this->phpunit->throwException(new ConstructorMetaDataException('TEST')));
	}

}
