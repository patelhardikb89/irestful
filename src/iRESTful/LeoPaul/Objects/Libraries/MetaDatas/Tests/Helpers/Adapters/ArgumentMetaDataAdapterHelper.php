<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Adapters\ArgumentMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ArgumentMetaDataAdapterHelper {
	private $phpunit;
	private $argumentMetaDataAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArgumentMetaDataAdapter $argumentMetaDataAdapterMock) {
		$this->phpunit = $phpunit;
		$this->argumentMetaDataAdapterMock = $argumentMetaDataAdapterMock;
	}

	public function expectsFromDataToArgumentMetaData_Success(ArgumentMetaData $returnedArgumentMetaData, array $data) {
		$this->argumentMetaDataAdapterMock->expects($this->phpunit->once())
											->method('fromDataToArgumentMetaData')
											->with($data)
											->will($this->phpunit->returnValue($returnedArgumentMetaData));
	}

	public function expectsFromDataToArgumentMetaData_multiple_Success(array $returnedArgumentMetaDatas, array $data) {
		foreach($returnedArgumentMetaDatas as $index => $oneArgumentMetaData) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('fromDataToArgumentMetaData')
							->with($data[$index])
                            ->will($this->phpunit->returnValue($oneArgumentMetaData));
        }
	}

	public function expectsFromDataToArgumentMetaData_throwsArgumentMetaDataException(array $data) {
		$this->argumentMetaDataAdapterMock->expects($this->phpunit->once())
											->method('fromDataToArgumentMetaData')
											->with($data)
											->will($this->phpunit->throwException(new ArgumentMetaDataException('TEST')));
	}

}
