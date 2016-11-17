<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetAdapterFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetAdapterFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetAdapterFactoryAdapterMock;
    private $entityPartialSetAdapterFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entityPartialSetAdapterFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\Adapters\EntityPartialSetAdapterFactoryAdapter');
        $this->entityPartialSetAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntityPartialSetAdapterFactoryAdapterHelper($this, $this->entityPartialSetAdapterFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSetAdapterFactory_Success() {

        $this->helper->expectsFromDataToEntityPartialSetAdapterFactory_Success($this->entityPartialSetAdapterFactoryMock, $this->data);

        $factory = $this->entityPartialSetAdapterFactoryAdapterMock->fromDataToEntityPartialSetAdapterFactory($this->data);

        $this->assertEquals($this->entityPartialSetAdapterFactoryMock, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_throwsEntityPartialSetException() {

        $this->helper->expectsFromDataToEntityPartialSetAdapterFactory_throwsEntityPartialSetException($this->data);

        $asserted = false;
        try {

            $this->entityPartialSetAdapterFactoryAdapterMock->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
