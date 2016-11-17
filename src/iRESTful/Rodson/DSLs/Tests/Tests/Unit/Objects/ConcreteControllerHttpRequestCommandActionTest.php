<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestCommandAction;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Exceptions\ActionException;

final class ConcreteControllerHttpRequestCommandActionTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {

    }

    public function tearDown() {

    }

    public function testCreate_isRetrieval_Success() {
        $action = new ConcreteControllerHttpRequestCommandAction(true, false, false, false);

        $this->assertTrue($action->isRetrieval());
        $this->assertFalse($action->isInsert());
        $this->assertFalse($action->isUpdate());
        $this->assertFalse($action->isDelete());
    }

    public function testCreate_isInsert_Success() {
        $action = new ConcreteControllerHttpRequestCommandAction(false, true, false, false);

        $this->assertFalse($action->isRetrieval());
        $this->assertTrue($action->isInsert());
        $this->assertFalse($action->isUpdate());
        $this->assertFalse($action->isDelete());
    }

    public function testCreate_isUpdate_Success() {
        $action = new ConcreteControllerHttpRequestCommandAction(false, false, true, false);

        $this->assertFalse($action->isRetrieval());
        $this->assertFalse($action->isInsert());
        $this->assertTrue($action->isUpdate());
        $this->assertFalse($action->isDelete());
    }

    public function testCreate_isDelete_Success() {
        $action = new ConcreteControllerHttpRequestCommandAction(false, false, false, true);

        $this->assertFalse($action->isRetrieval());
        $this->assertFalse($action->isInsert());
        $this->assertFalse($action->isUpdate());
        $this->assertTrue($action->isDelete());
    }

    public function testCreate_withoutAction_throwsActionException() {

        $asserted = false;
        try {

            new ConcreteControllerHttpRequestCommandAction(false, false, false, false);

        } catch (ActionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withMultipleActions_throwsActionException() {

        $asserted = false;
        try {

            new ConcreteControllerHttpRequestCommandAction(true, true, true, true);

        } catch (ActionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
