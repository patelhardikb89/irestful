<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Factories\ObjectAdapterFactoryHelper;

final class ObjectAdapterFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $objectAdapterFactoryMock;
    private $objectAdapterMock;
    private $helper;
    public function setUp() {
        $this->objectAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory');
        $this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');

        $this->helper = new ObjectAdapterFactoryHelper($this, $this->objectAdapterFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->objectAdapterMock);

        $objectAdapter = $this->objectAdapterFactoryMock->create();

        $this->assertEquals($this->objectAdapterMock, $objectAdapter);

    }

}
