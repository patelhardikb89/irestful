<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestView;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Views\Exceptions\ViewException;

final class ConcreteControllerHttpRequestViewTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {

    }

    public function tearDown() {

    }

    public function testCreate_isJson_Success() {

        $view = new ConcreteControllerHttpRequestView(true);

        $this->assertTrue($view->isJson());

    }

    public function testCreate_withoutView_Success() {

        $asserted = false;
        try {

            new ConcreteControllerHttpRequestView(false);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
