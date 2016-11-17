<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityRetrieverCriteriaAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRetrieverCriteriaAdapterMock;
    private $entityRetrieverCriteriaMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entityRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter');
        $this->entityRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria');

        $this->data = [
            'container' => 'my_container',
            'uuid' => 'f9cf73aa-5660-4214-a6be-73527b9f7c84'
        ];

        $this->helper = new EntityRetrieverCriteriaAdapterHelper($this, $this->entityRetrieverCriteriaAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToRetrieverCriteria_Success() {

        $this->helper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->data);

        $criteria = $this->entityRetrieverCriteriaAdapterMock->fromDataToRetrieverCriteria($this->data);

        $this->assertEquals($this->entityRetrieverCriteriaMock, $criteria);

    }

    public function testFromDataToRetrieverCriteria_throwsEntityException() {

        $this->helper->expectsFromDataToRetrieverCriteria_throwsEntityException($this->data);

        $asserted = false;
        try {

            $this->entityRetrieverCriteriaAdapterMock->fromDataToRetrieverCriteria($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
