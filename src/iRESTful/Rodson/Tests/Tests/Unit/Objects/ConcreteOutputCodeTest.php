<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteOutputCode;
use iRESTful\Rodson\Domain\Outputs\Codes\Exceptions\CodeException;

final class ConcreteOutputCodeTest extends \PHPUnit_Framework_TestCase {
    private $pathMock;
    private $code;
    public function setUp() {

        $this->pathMock = $this->getMock('iRESTful\Rodson\Domain\Outputs\Codes\Paths\Path');

        $this->code = '
        <?php
            $some = "code";
        ';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $code = new ConcreteOutputCode($this->code, $this->pathMock);

        $this->assertEquals($this->code, $code->getCode());
        $this->assertEquals($this->pathMock, $code->getPath());

    }

    public function testCreate_withEmptyCode_throwsCodeException() {

        $asserted = false;
        try {

            new ConcreteOutputCode('', $this->pathMock);

        } catch (CodeException $Exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringCode_throwsCodeException() {

        $asserted = false;
        try {

            new ConcreteOutputCode(new \DateTime(), $this->pathMock);

        } catch (CodeException $Exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
