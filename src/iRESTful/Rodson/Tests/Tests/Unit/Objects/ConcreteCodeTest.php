<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteCode;
use iRESTful\Rodson\Domain\Inputs\Codes\Exceptions\CodeException;

final class ConcreteCodeTest extends \PHPUnit_Framework_TestCase {
    private $languageMock;
    private $code;
    public function setUp() {
        $this->languageMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Languages\Language');

        $this->className = 'iRESTful\Rodson\Tests\Tests\Unit\Objects\ConcreteCodeTest';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $code = new ConcreteCode($this->languageMock, $this->className);

        $this->assertEquals($this->languageMock, $code->getLanguage());
        $this->assertEquals($this->className, $code->getClassName());

    }

    public function testCreate_withInvalidClassName_throwsCodeException() {

        $asserted = false;
        try {

            new ConcreteCode($this->languageMock, 'this is not a valid class name.');

        } catch (CodeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }


    public function testCreate_withEmptyCode_throwsCodeException() {

        $asserted = false;
        try {

            new ConcreteCode($this->languageMock, '');

        } catch (CodeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringCode_throwsCodeException() {

        $asserted = false;
        try {

            new ConcreteCode($this->languageMock, new \DateTime());

        } catch (CodeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
