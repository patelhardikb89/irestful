<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetAdapterMock;
    private $entityPartialSetMock;
    private $data;
    private $fromData;
    private $helper;
    public function setUp() {
        $this->entityPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter');
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');

        $index = rand(0, 100);
        $totalAmount = $index + rand(1, 100);

        $this->data = [
            'index' => $index,
            'amount' => 0,
            'total_amount' => $totalAmount
        ];

        $this->fromData = [
            'index' => $index,
            'total_amount' => $totalAmount
        ];

        $this->helper = new EntityPartialSetAdapterHelper($this, $this->entityPartialSetAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSet_Success() {

        $this->helper->expectsFromDataToEntityPartialSet_Success($this->entityPartialSetMock, $this->fromData);

        $entityPartialSet = $this->entityPartialSetAdapterMock->fromDataToEntityPartialSet($this->fromData);

        $this->assertEquals($this->entityPartialSetMock, $entityPartialSet);

    }

    public function testFromDataToEntityPartialSet_throwsEntityPartialSetException() {

        $this->helper->expectsFromDataToEntityPartialSet_throwsEntityPartialSetException($this->fromData);

        $asserted = false;
        try {

            $this->entityPartialSetAdapterMock->fromDataToEntityPartialSet($this->fromData);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityPartialSetToData_Success() {

        $this->helper->expectsFromEntityPartialSetToData_Success($this->data, $this->entityPartialSetMock);

        $data = $this->entityPartialSetAdapterMock->fromEntityPartialSetToData($this->entityPartialSetMock);

        $this->assertEquals($this->data, $data);

    }

    public function testFromEntityPartialSetToData_throwsEntityPartialSetException() {

        $this->helper->expectsFromEntityPartialSetToData_throwsEntityPartialSetException($this->entityPartialSetMock);

        $asserted = false;
        try {

            $this->entityPartialSetAdapterMock->fromEntityPartialSetToData($this->entityPartialSetMock);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
