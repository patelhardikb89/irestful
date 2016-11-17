<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters\ConcretePhysicalFilePathAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Exceptions\PathException;

final class ConcretePhysicalFilePathAdapterTest extends \PHPUnit_Framework_TestCase {
	private $basePath;
	private $baseUrl;
	private $adapter;
	private $path;
	private $pathWithExtension;
	public function setUp() {

		$this->basePath = realpath(__DIR__.'/../..');
		$this->baseUrl = 'http://myurl.com';

		$this->adapter = new ConcretePhysicalFilePathAdapter($this->basePath, $this->baseUrl);
		$this->path = '/Helpers/SaveTo/myFile';
		$this->pathWithExtension = '/Helpers/SaveTo/myFile.tmp';
	}

	public function tearDown() {

	}

	public function testConvertStringToPath_Success() {

		file_put_contents($this->basePath.$this->path, 'test');

		$filePath = $this->adapter->fromRelativePathStringToPath($this->path);

		$this->assertEquals($this->basePath.$this->path, $filePath->get());
		$this->assertEquals($this->path, $filePath->getRelative());

		unlink($this->basePath.$this->path);

	}

	public function testConvertStringToPath_withExtension_Success() {

		file_put_contents($this->basePath.$this->pathWithExtension, 'test');

		$filePath = $this->adapter->fromRelativePathStringToPath($this->pathWithExtension);

		$this->assertEquals($this->basePath.$this->pathWithExtension, $filePath->get());
		$this->assertEquals($this->pathWithExtension, $filePath->getRelative());

		unlink($this->basePath.$this->pathWithExtension);

	}

	public function testConvertStringToPath_withInvalidPath_throwsPathException() {

		$asserted = false;
		try {

			$this->adapter->fromRelativePathStringToPath($this->path);

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
