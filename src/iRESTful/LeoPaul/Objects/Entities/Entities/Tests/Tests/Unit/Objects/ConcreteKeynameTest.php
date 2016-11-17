<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteKeyname;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;

final class ConcreteKeynameTest extends \PHPUnit_Framework_TestCase {
    private $keyname;
    private $value;
    private $integerValue;
    private $floatValue;
    private $zeroValue;
    public function setUp() {

        $this->keyname = 'my_keyname';
        $this->value = 'some_random_value';
        $this->integerValue = rand(1, 5000);
        $this->floatValue = (float) rand(1, 100) / 100;
        $this->zeroValue = 0;
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $keyname = new ConcreteKeyname($this->keyname, $this->value);

        $this->assertEquals($this->keyname, $keyname->getName());
        $this->assertEquals($this->value, $keyname->getValue());

    }

    public function testCreate_withIntegerValue_Success() {

        $keyname = new ConcreteKeyname($this->keyname, $this->integerValue);

        $this->assertEquals($this->keyname, $keyname->getName());
        $this->assertEquals($this->integerValue, $keyname->getValue());

    }

    public function testCreate_withFloatValue_Success() {

        $keyname = new ConcreteKeyname($this->keyname, $this->floatValue);

        $this->assertEquals($this->keyname, $keyname->getName());
        $this->assertEquals($this->floatValue, $keyname->getValue());

    }

    public function testCreate_withZeroValue_Success() {

        $keyname = new ConcreteKeyname($this->keyname, $this->zeroValue);

        $this->assertEquals($this->keyname, $keyname->getName());
        $this->assertEquals($this->zeroValue, $keyname->getValue());

    }

    public function testCreate_withEmptyKeyname_throwsKeynameException() {

        $asserted = false;
        try {

            new ConcreteKeyname('', $this->value);

        } catch (KeynameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withObjectValue_throwsKeynameException() {

        $asserted = false;
        try {

            new ConcreteKeyname($this->keyname, new \DateTime());

        } catch (KeynameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withArrayValue_throwsKeynameException() {

        $asserted = false;
        try {

            new ConcreteKeyname($this->keyname, array());

        } catch (KeynameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNullValue_throwsKeynameException() {

        $asserted = false;
        try {

            new ConcreteKeyname($this->keyname, null);

        } catch (KeynameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
