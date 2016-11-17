<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRelationRetrieverCriteriaAdapterHelper;

final class EntityRelationRetrieverCriteriaAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRetrieverCriteriaAdapterMock;
    private $entityRelationRetrieverCriteriaMock;
    private $data;
    private $helper;
    public function setUp() {

        $this->entityRelationRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter');
        $this->entityRelationRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria');

        $this->data = [
            'master_container' => 'roles',
            'slave_container' => 'permissions',
            'slave_property' => 'pernission',
            'master_uuid' => '960eada9-1cef-489e-baee-51bd4b3c4cae'
        ];

        $this->helper = new EntityRelationRetrieverCriteriaAdapterHelper($this, $this->entityRelationRetrieverCriteriaAdapterMock);

    }

    public function tearDown() {

    }

    public function testFromDataToEntityRelationRetrieverCriteria_Success() {

        $this->helper->expectsFromDataToEntityRelationRetrieverCriteria_Success($this->entityRelationRetrieverCriteriaMock, $this->data);

        $criteria = $this->entityRelationRetrieverCriteriaAdapterMock->fromDataToEntityRelationRetrieverCriteria($this->data);

        $this->assertEquals($this->entityRelationRetrieverCriteriaMock, $criteria);

    }

    public function testFromDataToEntityRelationRetrieverCriteria_throwsEntityRelationException() {

        $this->helper->expectsFromDataToEntityRelationRetrieverCriteria_throwsEntityRelationException($this->data);

        $asserted = false;
        try {

            $this->entityRelationRetrieverCriteriaAdapterMock->fromDataToEntityRelationRetrieverCriteria($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
