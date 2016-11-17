<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Factories\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class UuidFactoryHelper {
	private $phpunit;
	private $factoryMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, UuidFactory $factoryMock) {
		$this->phpunit = $phpunit;
		$this->factoryMock = $factoryMock;
	}

	public function expectsCreate_Success(Uuid $returnedUuid) {
		$this->factoryMock->expects($this->phpunit->once())
							->method('create')
							->will($this->phpunit->returnValue($returnedUuid));
	}

    public function expectsCreate_multiple_Success(array $returnedUuids) {
		foreach($returnedUuids as $index => $oneUuid) {
            $this->factoryMock->expects($this->phpunit->at($index))
                                ->method('create')
                                ->will($this->phpunit->returnValue($oneUuid));
        }
	}

	public function expectsCreate_throwsUuidException() {
		$this->factoryMock->expects($this->phpunit->once())
							->method('create')
							->will($this->phpunit->throwException(new UuidException('TEST')));
	}

}
