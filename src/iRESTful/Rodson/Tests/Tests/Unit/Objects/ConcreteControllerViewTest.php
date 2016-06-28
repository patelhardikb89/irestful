<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteControllerView;
use iRESTful\Rodson\Domain\Controllers\Views\Exceptions\ViewException;

final class ConcreteControllerViewTest extends \PHPUnit_Framework_TestCase {
    private $codeMock;
    private $name;
    public function setUp() {
        $this->codeMock = $this->getMock('iRESTful\Rodson\Domain\Codes\Code');

        $this->name = 'MyView';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $view = new ConcreteControllerView($this->name, $this->codeMock);

        $this->assertEquals($this->name, $view->getName());
        $this->assertEquals($this->codeMock, $view->getCode());

    }

    public function testCreate_withEmptyName_throwsViewException() {

        $asserted = false;
        try {

            new ConcreteControllerView('', $this->codeMock);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsViewException() {

        $asserted = false;
        try {

            new ConcreteControllerView(new \DateTime(), $this->codeMock);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
