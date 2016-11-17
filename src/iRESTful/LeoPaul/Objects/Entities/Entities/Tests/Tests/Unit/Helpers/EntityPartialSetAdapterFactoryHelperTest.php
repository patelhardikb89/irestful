<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityPartialSetAdapterFactoryHelper;

final class EntityPartialSetAdapterFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetAdapterFactoryMock;
    private $entityPartialSetAdapterMock;
    private $helper;
    public function setUp() {
        $this->entityPartialSetAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory');
        $this->entityPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter');

        $this->helper = new EntityPartialSetAdapterFactoryHelper($this, $this->entityPartialSetAdapterFactoryMock);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entityPartialSetAdapterMock);

        $adapter = $this->entityPartialSetAdapterFactoryMock->create();

        $this->assertEquals($this->entityPartialSetAdapterMock, $adapter);

    }

}
