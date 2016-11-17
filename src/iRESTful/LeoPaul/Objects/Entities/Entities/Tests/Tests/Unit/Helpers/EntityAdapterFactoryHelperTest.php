<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityAdapterFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $helper;
    public function setUp() {
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');

        $this->helper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entityAdapterMock);

        $entityAdapter = $this->entityAdapterFactoryMock->create();

        $this->assertEquals($this->entityAdapterMock, $entityAdapter);

    }

    public function testCreate_throwsEntityException() {

        $this->helper->expectsCreate_throwsEntityException();

        $asserted = false;
        try {

            $this->entityAdapterFactoryMock->create();

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
