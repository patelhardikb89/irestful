<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteCode;
use iRESTful\DSLs\Domain\Projects\Codes\Exceptions\CodeException;

final class ConcreteCodeTest extends \PHPUnit_Framework_TestCase {
    private $languageMock;
    private $code;
    public function setUp() {
        $this->languageMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Codes\Languages\Language');

        $this->className = 'iRESTful\DSLs\Tests\Tests\Unit\Objects\ConcreteCodeTest';
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

}
