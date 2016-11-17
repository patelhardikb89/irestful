<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityPartialSetRetrieverCriteriaHelper;

final class EntityPartialSetRetrieverCriteriaHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRetrieverCriteriaMock;
    private $orderingMock;
    private $containerName;
    private $index;
    private $amount;
    private $helper;
    public function setUp() {
        $this->entityPartialSetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->containerName = 'my_container';
        $this->index = rand(0, 100);
        $this->amount = rand(1, 100);

        $this->helper = new EntityPartialSetRetrieverCriteriaHelper($this, $this->entityPartialSetRetrieverCriteriaMock);
    }

    public function tearDown() {

    }

    public function testGetContainerName_Success() {

        $this->helper->expectsGetContainerName_Success($this->containerName);

        $containerName = $this->entityPartialSetRetrieverCriteriaMock->getContainerName();

        $this->assertEquals($this->containerName, $containerName);

    }

    public function testGetIndex_Success() {

        $this->helper->expectsGetIndex_Success($this->index);

        $index = $this->entityPartialSetRetrieverCriteriaMock->getIndex();

        $this->assertEquals($this->index, $index);

    }

    public function testGetAmount_Success() {

        $this->helper->expectsGetAmount_Success($this->amount);

        $amount = $this->entityPartialSetRetrieverCriteriaMock->getAmount();

        $this->assertEquals($this->amount, $amount);

    }

    public function testHasOrdering_Success() {

        $this->helper->expectsHasOrdering_Success(false);

        $hasOrdering = $this->entityPartialSetRetrieverCriteriaMock->hasOrdering();

        $this->assertFalse($hasOrdering);

    }

    public function testGetOrdering_Success() {

        $this->helper->expectsGetOrdering_Success($this->orderingMock);

        $ordering = $this->entityPartialSetRetrieverCriteriaMock->getOrdering();

        $this->assertEquals($this->orderingMock, $ordering);

    }

}
