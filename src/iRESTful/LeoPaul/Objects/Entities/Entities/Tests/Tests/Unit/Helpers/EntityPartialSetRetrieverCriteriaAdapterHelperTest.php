<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRetrieverCriteriaAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRetrieverCriteriaAdapterMock;
    private $entityPartialSetRetrieverCriteriaMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entityPartialSetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter');
        $this->entityPartialSetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria');

        $this->data = [
            'container' => 'my_container',
            'index' => rand(0, 100),
            'amount' => rand(0, 100)
        ];

        $this->helper = new EntityPartialSetRetrieverCriteriaAdapterHelper($this, $this->entityPartialSetRetrieverCriteriaAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_Success() {

        $this->helper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->data);

        $criteria = $this->entityPartialSetRetrieverCriteriaAdapterMock->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        $this->assertEquals($this->entityPartialSetRetrieverCriteriaMock, $criteria);

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException() {

        $this->helper->expectsFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException($this->data);

        $asserted = false;
        try {

            $this->entityPartialSetRetrieverCriteriaAdapterMock->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
