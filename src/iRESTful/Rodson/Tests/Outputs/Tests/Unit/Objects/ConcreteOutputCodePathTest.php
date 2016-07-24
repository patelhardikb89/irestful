<?php
namespace iRESTful\Rodson\Tests\Outputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\ConcreteOutputCodePath;
use iRESTful\Rodson\Tests\Outputs\Helpers\Objects\FileHelper;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Exceptions\PathException;

final class ConcreteOutputCodePathTest extends \PHPUnit_Framework_TestCase {
    private $fileMock;
    private $basePath;
    private $relativePath;
    private $file;
    private $fullPath;
    private $fileHelper;
    public function setUp() {
        $this->fileMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\File');

        $this->basePath = [
            'vagrant'
        ];

        $this->relativePath = [
            'new',
            'path'
        ];

        $this->file = 'myFile.php';

        $this->fullPath = array_merge($this->basePath, $this->relativePath, [$this->file]);

        $this->fileHelper = new FileHelper($this, $this->fileMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->fileHelper->expectsGet_Success($this->file);

        $path = new ConcreteOutputCodePath($this->basePath, $this->relativePath, $this->fileMock);

        $this->assertEquals($this->fullPath, $path->getPath());
        $this->assertEquals($this->relativePath, $path->getRelativePath());
        $this->assertEquals($this->fileMock, $path->getFile());

    }

    public function testCreate_withNonExistingBasePath_Success() {

        $asserted = false;
        try {

            new ConcreteOutputCodePath(['invalid', 'folder', 'path'], $this->relativePath, $this->fileMock);

        } catch (PathException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidElementInBasePath_Success() {

        $this->basePath[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteOutputCodePath($this->basePath, $this->relativePath, $this->fileMock);

        } catch (PathException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidElementInRelativePath_Success() {

        $this->relativePath[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteOutputCodePath($this->basePath, $this->relativePath, $this->fileMock);

        } catch (PathException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyRelativePath_Success() {

        $this->relativePath[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteOutputCodePath($this->basePath, [], $this->fileMock);

        } catch (PathException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyBasePath_Success() {

        $this->relativePath[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteOutputCodePath([], $this->relativePath, $this->fileMock);

        } catch (PathException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }


}
