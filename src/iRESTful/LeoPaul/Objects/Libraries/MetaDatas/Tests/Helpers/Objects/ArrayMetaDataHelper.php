<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData;

final class ArrayMetaDataHelper {
	private $phpunit;
	private $arrayMetaDataMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ArrayMetaData $arrayMetaDataMock) {
		$this->phpunit = $phpunit;
		$this->arrayMetaDataMock = $arrayMetaDataMock;
	}

	public function expectsHasElementsType_Success($returnedBoolean) {
		$this->arrayMetaDataMock->expects($this->phpunit->once())
									->method('hasElementsType')
									->will($this->phpunit->returnValue($returnedBoolean));
	}

	public function expectsGetElementsType_Success($returnedElementType) {
		$this->arrayMetaDataMock->expects($this->phpunit->once())
									->method('getElementsType')
									->will($this->phpunit->returnValue($returnedElementType));
	}

}
