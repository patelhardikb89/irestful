<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteServerFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters\ServerAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories\NativePDOFactoryHelper;

final class ConcreteServerFactoryTest extends \PHPUnit_Framework_TestCase {
    private $serverAdapterMock;
    private $serverMock;
    private $nativePDOFactoryMock;
    private $nativePDOMock;
    private $factory;
    private $nativePDOFactoryHelper;
    private $serverAdapterHelper;
    public function setUp() {

        $this->serverAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Adapters\ServerAdapter');
        $this->serverMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server');
        $this->nativePDOFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Factories\NativePDOFactory');
        $this->nativePDOMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO');

        $this->factory = new ConcreteServerFactory($this->serverAdapterMock , $this->nativePDOFactoryMock);

        $this->nativePDOFactoryHelper = new NativePDOFactoryHelper($this, $this->nativePDOFactoryMock);
        $this->serverAdapterHelper = new ServerAdapterHelper($this, $this->serverAdapterMock);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->nativePDOFactoryHelper->expectsCreate_Success($this->nativePDOMock);
        $this->serverAdapterHelper->expectsFromNativePDOToServer_Success($this->serverMock , $this->nativePDOMock);

        $server = $this->factory->create();

        $this->assertEquals($this->serverMock, $server);

    }

    public function testCreate_throwsServerException_throwsServerException() {

        $this->nativePDOFactoryHelper->expectsCreate_Success($this->nativePDOMock);
        $this->serverAdapterHelper->expectsFromNativePDOToServer_throwsServerException($this->nativePDOMock);

        $asserted = false;
        try {

            $this->factory->create();

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_throwsNativePDOException_throwsServerException() {

        $this->nativePDOFactoryHelper->expectsCreate_throwsNativePDOException();

        $asserted = false;
        try {

            $this->factory->create();

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
