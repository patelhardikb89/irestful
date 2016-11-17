<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters\MicroDateTimeClosureAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class MicroDateTimeClosureAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $microDateTimeClosureAdapterMock;
    private $microDateTimeClosureMock;
    private $closure;
    private $helper;
    public function setUp() {
        $this->microDateTimeClosureAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter');
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');

        $this->closure = function() {

        };

        $this->helper = new MicroDateTimeClosureAdapterHelper($this, $this->microDateTimeClosureAdapterMock );
    }

    public function tearDown() {

    }

    public function testFromClosureToMicroDateTimeClosure_Success() {

        $this->helper->expectsFromClosureToMicroDateTimeClosure_Success($this->microDateTimeClosureMock, $this->closure);

        $microDateTimeClosure = $this->microDateTimeClosureAdapterMock->fromClosureToMicroDateTimeClosure($this->closure);

        $this->assertEquals($this->microDateTimeClosureMock, $microDateTimeClosure);

    }

    public function testFromClosureToMicroDateTimeClosure_throwsMicroDateTimeClosureException() {

        $this->helper->expectsFromClosureToMicroDateTimeClosure_throwsMicroDateTimeClosureException($this->closure);

        $asserted = false;
        try {

            $this->microDateTimeClosureAdapterMock->fromClosureToMicroDateTimeClosure($this->closure);

        } catch (MicroDateTimeClosureException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
