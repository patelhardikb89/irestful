<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerView;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Exceptions\ViewException;

final class ConcreteControllerViewTest extends \PHPUnit_Framework_TestCase {
    private $templateMock;
    public function setUp() {
        $this->templateMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Controllers\Views\Templates\Template');
    }

    public function tearDown() {

    }

    public function testCreate_isJson_Success() {

        $view = new ConcreteControllerView(true);

        $this->assertTrue($view->isJson());
        $this->assertFalse($view->hasTemplate());
        $this->assertNull($view->getTemplate());

    }

    public function testCreate_withTemplate_Success() {

        $view = new ConcreteControllerView(false, $this->templateMock);

        $this->assertFalse($view->isJson());
        $this->assertTrue($view->hasTemplate());
        $this->assertEquals($this->templateMock, $view->getTemplate());

    }

    public function testCreate_withoutView_throwsViewException() {

        $asserted = false;
        try {

            new ConcreteControllerView(false);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withMultipleView_throwsViewException() {

        $asserted = false;
        try {

            new ConcreteControllerView(true, $this->templateMock);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
