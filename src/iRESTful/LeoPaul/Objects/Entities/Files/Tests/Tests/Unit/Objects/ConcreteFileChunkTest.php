<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFileChunk;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteFileChunkTest extends \PHPUnit_Framework_TestCase {
	private $uuidMock;
	private $physicalFileMock;
	private $createdOn;
	private $index;
	public function setUp() {
		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
		$this->physicalFileMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile');
		$this->createdOn = new \DateTime();

		$this->index = rand(1, 500);

	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$fileChunk = new ConcreteFileChunk($this->uuidMock, $this->createdOn, $this->physicalFileMock, $this->uuidMock, $this->index);

		$this->assertEquals($this->uuidMock, $fileChunk->getUuid());
		$this->assertEquals($this->createdOn, $fileChunk->createdOn());
		$this->assertEquals($this->physicalFileMock, $fileChunk->getPhysicalFile());
		$this->assertEquals($this->uuidMock, $fileChunk->getFutureFileUuid());
		$this->assertEquals($this->index, $fileChunk->getIndex());

	}

	public function testCreate_indexIsUnderZero_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFileChunk($this->uuidMock, $this->createdOn, $this->physicalFileMock, $this->uuidMock, -1);

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
