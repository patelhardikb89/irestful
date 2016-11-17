<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFile;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteFileTest extends \PHPUnit_Framework_TestCase {
	private $uuidMock;
	private $physicalFileMock;
	private $chunkMock;
	private $createdOn;
	private $sizeInBytes;
	private $mimeType;
	public function setUp() {

		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
		$this->physicalFileMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile');
		$this->chunkMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Chunk');
		$this->createdOn = new \DateTime();
		$this->sizeInBytes = rand(1, 5000);
		$this->mimeType = 'image/jpeg';

	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$this->chunkMock->expects($this->exactly(2))
							->method('getIndex')
							->will($this->returnValue(0));

		$file = new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [$this->chunkMock], $this->sizeInBytes, $this->mimeType);

		$this->assertEquals($this->uuidMock, $file->getUuid());
		$this->assertEquals($this->createdOn, $file->createdOn());
		$this->assertEquals($this->physicalFileMock, $file->getPhysicalFile());
		$this->assertEquals([$this->chunkMock], $file->getChunks());
		$this->assertEquals($this->sizeInBytes, $file->getSizeInBytes());
		$this->assertEquals($this->mimeType, $file->getMimeType());

	}

	public function testCreate_withNonStringMimeType_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [$this->chunkMock], $this->sizeInBytes, new \DateTime());

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyMimeType_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [$this->chunkMock], $this->sizeInBytes, '');

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withZeroBytesInSize_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [$this->chunkMock], 0, $this->mimeType);

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidSizeInBytes_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [$this->chunkMock], new \DateTime(), $this->mimeType);

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withoutChunks_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [], $this->sizeInBytes, $this->mimeType);

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidChunks_throwsEntityException() {

		$asserted = false;
		try {

			new ConcreteFile($this->uuidMock, $this->createdOn, $this->physicalFileMock, [new \DateTime()], $this->sizeInBytes, $this->mimeType);

		} catch (EntityException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
