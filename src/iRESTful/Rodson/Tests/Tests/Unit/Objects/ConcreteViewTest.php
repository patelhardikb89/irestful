<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteView;
use iRESTful\Rodson\Domain\Views\Exceptions\ViewException;

final class ConcreteViewTest extends \PHPUnit_Framework_TestCase {
    private $methodMock;
    private $name;
    public function setUp() {
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Codes\Methods\Method');

        $this->name = 'MyView';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $view = new ConcreteView($this->name, $this->methodMock);

        $this->assertEquals($this->name, $view->getName());
        $this->assertEquals($this->methodMock, $view->getMethod());

    }

    public function testCreate_withEmptyName_throwsViewException() {

        $asserted = false;
        try {

            new ConcreteView('', $this->methodMock);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsViewException() {

        $asserted = false;
        try {

            new ConcreteView(new \DateTime(), $this->methodMock);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
