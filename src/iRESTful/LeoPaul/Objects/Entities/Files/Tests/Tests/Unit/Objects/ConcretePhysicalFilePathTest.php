<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcretePhysicalFilePath;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Exceptions\PathException;

final class ConcretePhysicalFilePathTest extends \PHPUnit_Framework_TestCase {
	private $basePath;
	private $baseUrl;
	private $directories;
	private $fileName;
	private $extension;
	private $directoryPath;
	public function setUp() {

		$this->basePath = realpath(__DIR__.'/../..');
		$this->baseUrl = 'http://myurl.com';
		$this->directoryPath = '/Helpers/SaveTo';
		$this->directories = explode('/', $this->directoryPath);
		$this->fileName = 'myFile';
		$this->extension = 'tmp';
	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$relativePath = $this->directoryPath.'/'.$this->fileName;
		$path = $this->basePath.$relativePath;

		//create the file first:
		file_put_contents($path, 'test');

		$filePath = new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, $this->fileName);

		$this->assertEquals($path, $filePath->get());
		$this->assertEquals($relativePath, $filePath->getRelative());
		$this->assertEquals($this->fileName, $filePath->getFileName());
		$this->assertEquals($this->directories, $filePath->getDirectories());
		$this->assertEquals($this->baseUrl.$this->directoryPath.'/'.$this->fileName, $filePath->getUrl());
		$this->assertFalse($filePath->hasExtension());
		$this->assertNull($filePath->getExtension());

		//delete file:
		unlink($path);
	}

	public function testCreate_withExtension_Success() {

		$relativePath = $this->directoryPath.'/'.$this->fileName.'.'.$this->extension;
		$path = $this->basePath.$relativePath;

		//create the file first:
		file_put_contents($path, 'test');

		$filePath = new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, $this->fileName, $this->extension);

		$this->assertEquals($path, $filePath->get());
		$this->assertEquals($relativePath, $filePath->getRelative());
		$this->assertEquals($this->fileName, $filePath->getFileName());
		$this->assertEquals($this->directories, $filePath->getDirectories());
		$this->assertEquals($this->baseUrl.$this->directoryPath.'/'.$this->fileName.'.'.$this->extension, $filePath->getUrl());
		$this->assertTrue($filePath->hasExtension());
		$this->assertEquals($this->extension, $filePath->getExtension());

		//delete file:
		unlink($path);
	}

	public function testCreate_withNonStringExtension_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, $this->fileName, new \DateTime());

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyExtension_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, $this->fileName, '');

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringFileName_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, new \DateTime());

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyFileName_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, '');

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidPath_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $this->directories, $this->fileName, $this->extension);

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyBaseUrl_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, '', $this->directories, $this->fileName, $this->extension);

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringBaseUrl_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath($this->basePath, new \DateTime(), $this->directories, $this->fileName, $this->extension);

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyBasePath_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath('', $this->baseUrl, $this->directories, $this->fileName, $this->extension);

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringBasePath_throwsPathException() {

		$asserted = false;
		try {

			new ConcretePhysicalFilePath(new \DateTime(), $this->baseUrl, $this->directories, $this->fileName, $this->extension);

		} catch (PathException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
