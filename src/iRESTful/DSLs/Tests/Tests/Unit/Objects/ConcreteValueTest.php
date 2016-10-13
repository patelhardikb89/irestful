<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteValue;
use iRESTful\DSLs\Domain\Projects\Values\Exceptions\ValueException;

final class ConcreteValueTest extends \PHPUnit_Framework_TestCase {
    private $inputVariable;
    private $environmentVariable;
    private $direct;
    public function setUp() {
        $this->inputVariable = 'input';
        $this->environmentVariable = 'my_env_variable';
        $this->direct = 'some value';
    }

    public function tearDown() {

    }

    public function testCreate_withInputVariable_Success() {

        $value = new ConcreteValue($this->inputVariable);

        $this->assertTrue($value->hasInputVariable());
        $this->assertEquals($this->inputVariable, $value->getInputVariable());
        $this->assertFalse($value->hasEnvironmentVariable());
        $this->assertNull($value->getEnvironmentVariable());
        $this->assertFalse($value->hasDirect());
        $this->assertNull($value->getDirect());

    }

    public function testCreate_withEnvironmentVariable_Success() {

        $value = new ConcreteValue(null, $this->environmentVariable);

        $this->assertFalse($value->hasInputVariable());
        $this->assertNull($value->getInputVariable());
        $this->assertTrue($value->hasEnvironmentVariable());
        $this->assertEquals($this->environmentVariable, $value->getEnvironmentVariable());
        $this->assertFalse($value->hasDirect());
        $this->assertNull($value->getDirect());

    }

    public function testCreate_withDirect_Success() {

        $value = new ConcreteValue(null, null, $this->direct);

        $this->assertFalse($value->hasInputVariable());
        $this->assertNull($value->getInputVariable());
        $this->assertFalse($value->hasEnvironmentVariable());
        $this->assertNull($value->getEnvironmentVariable());
        $this->assertTrue($value->hasDirect());
        $this->assertEquals($this->direct, $value->getDirect());

    }

    public function testCreate_withoutValue_throwsValueException() {

        $asserted = false;
        try {

            new ConcreteValue();

        } catch (ValueException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withMultipleValue_throwsValueException() {

        $asserted = false;
        try {

            new ConcreteValue($this->inputVariable, $this->environmentVariable, $this->direct);

        } catch (ValueException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
