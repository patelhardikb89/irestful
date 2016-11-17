<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Tests\Tests\Unit\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Services\ConcretePhysicalFileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters\ConcretePhysicalFilePathAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcretePhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Exceptions\PhysicalFileException;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters\ConcretePhysicalFileAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;

final class ConcretePhysicalFileServiceTest extends \PHPUnit_Framework_TestCase {
	private $basePath;
	private $baseUrl;
	private $service;
	private $filePathAdapter;
	private $saveTo;
	private $fileName;
	private $fromFilePath;
	private $timestamp;
	private $createdOn;
	private $content;
	public function setUp() {

		$this->basePath = realpath(__DIR__.'/../..');

		$this->baseUrl = 'http://myurl.com';

		$this->saveTo = '/Helpers/SaveTo';
		$this->filePathAdapter = new ConcretePhysicalFilePathAdapter($this->basePath, $this->baseUrl);
		$this->service = new ConcretePhysicalFileService(new ConcretePhysicalFileAdapter($this->filePathAdapter, new ConcreteDateTimeAdapter('America/Montreal')), $this->basePath, $this->saveTo);

		$this->fileName = 'myFile';
		$this->fromFilePath = $this->saveTo.'/'.$this->fileName;

		$this->timestamp = time();
		$this->createdOn = new \DateTime();
		$this->createdOn->setTimestamp($this->timestamp);
		$this->content = 'this is just some content.';
	}

	public function tearDown() {

	}

	public function testInsert_Success() {

		file_put_contents($this->basePath.$this->fromFilePath, 'test');
		$savedFile = $this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp).'/'.$this->fileName;

		$this->assertFalse(file_exists($savedFile));

		$path = $this->filePathAdapter->fromRelativePathStringToPath($this->fromFilePath);

		$originalFile = new ConcretePhysicalFile($path);
		$newFile = $this->service->insert($originalFile);

		$this->assertTrue(file_exists($savedFile));
		$this->assertEquals($savedFile, $newFile->getPath()->get());
		$this->assertEquals('test', file_get_contents($savedFile));

		unlink($this->basePath.$this->fromFilePath);
		unlink($savedFile);
		rmdir($this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp));
		rmdir($this->basePath.$this->saveTo.'/'.date('Y/m', $this->timestamp));
		rmdir($this->basePath.$this->saveTo.'/'.date('Y', $this->timestamp));

	}

	public function testInsert_withContent_Success() {

		$savedFile = $this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp).'/'.md5($this->content);

		$originalFile = new ConcretePhysicalFile(null, $this->content);
		$newFile = $this->service->insert($originalFile);

		$this->assertTrue(file_exists($savedFile));
		$this->assertEquals($savedFile, $newFile->getPath()->get());
		$this->assertEquals($this->content, file_get_contents($savedFile));

		unlink($savedFile);
		rmdir($this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp));
		rmdir($this->basePath.$this->saveTo.'/'.date('Y/m', $this->timestamp));
		rmdir($this->basePath.$this->saveTo.'/'.date('Y', $this->timestamp));

	}

	public function testInsert_cantCreateInFolder_throwsPhysicalFileException() {

		//chmod to 600, so that we cant write in it:
		mkdir($this->basePath.$this->saveTo.'/'.date('Y', $this->timestamp), 600);
		$savedFile = $this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp).'/'.$this->fileName;

		file_put_contents($this->basePath.$this->fromFilePath, 'test');
		$this->assertFalse(file_exists($savedFile));

		$path = $this->filePathAdapter->fromRelativePathStringToPath($this->fromFilePath);

		$originalFile = new ConcretePhysicalFile($path);

		$asserted = false;
		try {

			$this->service->insert($originalFile);

		} catch (PhysicalFileException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

		$this->assertFalse(file_exists($savedFile));

		unlink($this->basePath.$this->fromFilePath);
		rmdir($this->basePath.$this->saveTo.'/'.date('Y', $this->timestamp));

	}

	public function testInsert_cantCreateFile_throwsPhysicalFileException() {

		//chmod to 600, so that we cant write in it:
		$directoryPath = $this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp);
		mkdir($directoryPath, 0777, true);
		chmod($directoryPath, 600);
		$savedFile = $this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp).'/'.$this->fileName;

		file_put_contents($this->basePath.$this->fromFilePath, 'test');
		$this->assertFalse(file_exists($savedFile));

		$path = $this->filePathAdapter->fromRelativePathStringToPath($this->fromFilePath);
		$originalFile = new ConcretePhysicalFile($path);

		$asserted = false;
		try {

			$this->service->insert($originalFile);

		} catch (PhysicalFileException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

		$this->assertFalse(file_exists($savedFile));

		unlink($this->basePath.$this->fromFilePath);
		rmdir($this->basePath.$this->saveTo.'/'.date('Y/m/d', $this->timestamp));
		rmdir($this->basePath.$this->saveTo.'/'.date('Y/m', $this->timestamp));
		rmdir($this->basePath.$this->saveTo.'/'.date('Y', $this->timestamp));

	}

	public function testDelete_Success() {

		file_put_contents($this->basePath.$this->fromFilePath, 'test');
		$this->assertTrue(file_exists($this->basePath.$this->fromFilePath));

		$path = $this->filePathAdapter->fromRelativePathStringToPath($this->fromFilePath);
		$this->service->delete($path);

		$this->assertFalse(file_exists($this->basePath.$this->fromFilePath));

	}

	public function testDelete_withFileAlreadyDeleted_throwsPhysicalFileException() {

		file_put_contents($this->basePath.$this->fromFilePath, 'test');
		$this->assertTrue(file_exists($this->basePath.$this->fromFilePath));

		$path = $this->filePathAdapter->fromRelativePathStringToPath($this->fromFilePath);
		unlink($this->basePath.$this->fromFilePath);

		$asserted = false;
		try {
			$this->service->delete($path);

		} catch (PhysicalFileException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
