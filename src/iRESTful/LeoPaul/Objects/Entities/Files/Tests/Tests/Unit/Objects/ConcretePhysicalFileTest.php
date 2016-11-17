<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcretePhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Exceptions\PhysicalFileException;

final class ConcretePhysicalFileTest extends \PHPUnit_Framework_TestCase {
	private $pathMock;
	private $content;
	public function setUp() {
		$this->pathMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Path');

		$this->content = 'this is just content.';
	}

	public function tearDown() {

	}

	public function testCreate_withPath_Success() {

		$file = new ConcretePhysicalFile($this->pathMock);

		$this->assertTrue($file->hasPath());
		$this->assertEquals($this->pathMock, $file->getPath());
		$this->assertFalse($file->hasContent());
		$this->assertNull($file->getContent());
	}

	public function testCreate_withContent_Success() {

		$file = new ConcretePhysicalFile(null, $this->content);

		$this->assertFalse($file->hasPath());
		$this->assertNull($file->getPath());
		$this->assertTrue($file->hasContent());
		$this->assertEquals($this->content, $file->getContent());
	}

	public function testCreate_withContent_withPath_throwsPhysicalFileException() {

		$asserted = false;
		try {

			new ConcretePhysicalFile($this->pathMock, $this->content);

		} catch (PhysicalFileException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testCreate_withEmptyContent_throwsPhysicalFileException() {

		$asserted = false;
		try {

			new ConcretePhysicalFile(null, '');

		} catch (PhysicalFileException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

}
