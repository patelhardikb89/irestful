<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteOrdering;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;

final class ConcreteOrderingTest extends \PHPUnit_Framework_TestCase {
    private $names;
    public function setUp() {
        $this->names = ['slug', 'created_on'];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $ordering = new ConcreteOrdering($this->names, false);

        $this->assertEquals($this->names, $ordering->getNames());
        $this->assertFalse($ordering->isAscending());

    }

    public function testCreate_isAscending_Success() {

        $ordering = new ConcreteOrdering($this->names, true);

        $this->assertEquals($this->names, $ordering->getNames());
        $this->assertTrue($ordering->isAscending());

    }

    public function testCreate_withEmptyNames_throwsOrderingException() {

        $asserted = false;
        try {

            new ConcreteOrdering([], false);

        } catch (OrderingException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneNonStringName_throwsOrderingException() {

        $this->names[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteOrdering($this->names, false);

        } catch (OrderingException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
