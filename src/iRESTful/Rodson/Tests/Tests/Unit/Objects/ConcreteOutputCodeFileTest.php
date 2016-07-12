<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteOutputCodeFile;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Exceptions\FileException;

final class ConcreteOutputCodeFileTest extends \PHPUnit_Framework_TestCase {
    private $name;
    private $extension;
    private $fullName;
    public function setUp() {
        $this->name = 'myName';
        $this->extension = 'php';
        $this->fullName = $this->name.'.'.$this->extension;
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $file = new ConcreteOutputCodeFile($this->name, $this->extension);

        $this->assertEquals($this->name, $file->getName());
        $this->assertEquals($this->extension, $file->getExtension());
        $this->assertEquals($this->fullName, $file->get());

    }

    public function testCreate_withEmptyExtension_throwsFileException() {

        $asserted = false;
        try {

            new ConcreteOutputCodeFile($this->name, '');

        } catch (FileException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringExtension_throwsFileException() {

        $asserted = false;
        try {

            new ConcreteOutputCodeFile($this->name, new \DateTime());

        } catch (FileException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsFileException() {

        $asserted = false;
        try {

            new ConcreteOutputCodeFile('', $this->extension);

        } catch (FileException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsFileException() {

        $asserted = false;
        try {

            new ConcreteOutputCodeFile(new \DateTime(), $this->extension);

        } catch (FileException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
