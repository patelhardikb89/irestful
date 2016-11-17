<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntitySetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRetrieverCriteriaAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRetrieverCriteriaAdapterMock;
    private $entitySetRetrieverCriteriaMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entitySetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter');
        $this->entitySetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria');

        $this->data = [
            'container' => 'my_container',
            'uuids' => [
                '264733bb-1aeb-4099-809d-2dfeec52b284',
                'fe82371e-8005-4028-bc93-b926a50020cc'
            ]
        ];

        $this->helper = new EntitySetRetrieverCriteriaAdapterHelper($this, $this->entitySetRetrieverCriteriaAdapterMock );
    }

    public function tearDown() {

    }

    public function testFromDataToEntitySetRetrieverCriteria_Success() {

        $this->helper->expectsFromDataToEntitySetRetrieverCriteria_Success($this->entitySetRetrieverCriteriaMock, $this->data);

        $criteria = $this->entitySetRetrieverCriteriaAdapterMock->fromDataToEntitySetRetrieverCriteria($this->data);

        $this->assertEquals($this->entitySetRetrieverCriteriaMock, $criteria);

    }

    public function testFromDataToEntitySetRetrieverCriteria_throwsEntitySetException() {

        $this->helper->expectsFromDataToEntitySetRetrieverCriteria_throwsEntitySetException($this->data);

        $asserted = false;
        try {

            $this->entitySetRetrieverCriteriaAdapterMock->fromDataToEntitySetRetrieverCriteria($this->data);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
