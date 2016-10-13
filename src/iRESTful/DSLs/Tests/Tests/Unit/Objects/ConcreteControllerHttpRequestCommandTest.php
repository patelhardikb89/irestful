<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestCommand;

final class ConcreteControllerHttpRequestCommandTest extends \PHPUnit_Framework_TestCase {
    private $actionMock;
    private $urlMock;
    public function setUp() {
        $this->actionMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Action');
        $this->urlMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Url');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $command = new ConcreteControllerHttpRequestCommand($this->actionMock, $this->urlMock);

        $this->assertEquals($this->actionMock, $command->getAction());
        $this->assertEquals($this->urlMock, $command->getUrl());

    }

}
