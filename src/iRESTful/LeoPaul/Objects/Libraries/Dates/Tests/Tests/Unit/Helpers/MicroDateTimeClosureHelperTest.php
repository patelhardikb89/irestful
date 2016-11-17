<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeClosureHelper;

final class MicroDateTimeClosureHelperTest extends \PHPUnit_Framework_TestCase {
    private $microDateTimeClosureMock;
    private $microDateTimeMock;
    private $closure;
    private $results;
    private $helper;
    public function setUp() {
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');
        $this->microDateTimeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime');

        $this->closure = function() {

        };

        $this->results = 'this is some results';

        $this->helper = new MicroDateTimeClosureHelper($this, $this->microDateTimeClosureMock);
    }

    public function tearDown() {

    }

    public function testGetClosure_Success() {

        $this->helper->expectsGetClosure_Success($this->closure);

        $closure = $this->microDateTimeClosureMock->getClosure();

        $this->assertEquals($this->closure, $closure);

    }

    public function testStartedOn_Success() {

        $this->helper->expectsStartedOn_Success($this->microDateTimeMock);

        $startedOn = $this->microDateTimeClosureMock->startedOn();

        $this->assertEquals($this->microDateTimeMock, $startedOn);

    }

    public function testEndsOn_Success() {

        $this->helper->expectsEndsOn_Success($this->microDateTimeMock);

        $endsOn = $this->microDateTimeClosureMock->endsOn();

        $this->assertEquals($this->microDateTimeMock, $endsOn);

    }

    public function testHasResults_Success() {

        $this->helper->expectsHasResults_Success(true);

        $hasResults = $this->microDateTimeClosureMock->hasResults();

        $this->assertTrue($hasResults);

    }

    public function testGetResults_Success() {

        $this->helper->expectsGetResults_Success($this->results);

        $results = $this->microDateTimeClosureMock->getResults();

        $this->assertEquals($this->results, $results);

    }

}
