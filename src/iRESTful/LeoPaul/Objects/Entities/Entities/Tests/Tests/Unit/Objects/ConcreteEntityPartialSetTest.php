<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class ConcreteEntityPartialSetTest extends \PHPUnit_Framework_TestCase {
    private $entityMock;
    private $index;
    private $amount;
    private $totalAmount;
    private $entities;
    private $invalidEntities;
    public function setUp() {

        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->index = rand(0, 100);
        $this->amount = count($this->entities);
        $this->totalAmount = $this->index + $this->amount + rand(0, 500);



        $this->invalidEntities = array_merge($this->entities, [new \DateTime()]);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $partialSet = new ConcreteEntityPartialSet($this->index, $this->totalAmount, $this->entities);

        $this->assertEquals($this->index, $partialSet->getIndex());
        $this->assertEquals($this->amount, $partialSet->getAmount());
        $this->assertEquals($this->totalAmount, $partialSet->getTotalAmount());
        $this->assertTrue($partialSet->hasEntities());
        $this->assertEquals($this->entities , $partialSet->getEntities());

    }

    public function testCreate_withOneNonEntityObjectInEntities_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSet($this->index, $this->totalAmount, $this->invalidEntities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerIndex_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSet((string) $this->index, $this->totalAmount, $this->entities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeIndex_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSet(rand(1, 500) * -1, $this->totalAmount, $this->entities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeTotalAmount_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSet($this->index, rand(1, 500) * -1, $this->entities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerTotalAmount_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSet($this->index, (string) $this->totalAmount, $this->entities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTotalAmountLowerThanIndexPlusAmount_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            new ConcreteEntityPartialSet($this->index, $this->index + count($this->entities) - 1, $this->entities);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
