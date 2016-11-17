<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class ConcreteEntityPartialSetRetrieverCriteriaTest extends \PHPUnit_Framework_TestCase {
    private $orderingMock;
    private $containerName;
    private $index;
    private $amount;
    public function setUp() {

        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->containerName = 'my_container';
        $this->index = rand(0, 100);
        $this->amount = rand(1, 100);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $partialSetRetrieverCriteria = new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, $this->index, $this->amount);

        $this->assertEquals($this->containerName, $partialSetRetrieverCriteria->getContainerName());
        $this->assertEquals($this->index, $partialSetRetrieverCriteria->getIndex());
        $this->assertEquals($this->amount, $partialSetRetrieverCriteria->getAmount());
        $this->assertFalse($partialSetRetrieverCriteria->hasOrdering());
        $this->assertNull($partialSetRetrieverCriteria->getOrdering());

    }

    public function testCreate_withOrdering_Success() {

        $partialSetRetrieverCriteria = new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, $this->index, $this->amount, $this->orderingMock);

        $this->assertEquals($this->containerName, $partialSetRetrieverCriteria->getContainerName());
        $this->assertEquals($this->index, $partialSetRetrieverCriteria->getIndex());
        $this->assertEquals($this->amount, $partialSetRetrieverCriteria->getAmount());
        $this->assertTrue($partialSetRetrieverCriteria->hasOrdering());
        $this->assertEquals($this->orderingMock, $partialSetRetrieverCriteria->getOrdering());

    }

    public function testCreate_withNonStringContainerName_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria(rand(1, 100), $this->index, $this->amount);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyContainerName_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria('', $this->index, $this->amount);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerIndex_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, (string) $this->index, $this->amount);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerAmount_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, $this->index, (string) $this->amount);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeIndex_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, rand(1, 100) * -1, $this->amount);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeAmount_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, $this->index, rand(1, 100) * -1);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroAmount_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSetRetrieverCriteria($this->containerName, $this->index, 0);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
