<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\KeynameHelper;

final class KeynameHelperTest extends \PHPUnit_Framework_TestCase {
    private $keynameMock;
    private $name;
    private $value;
    private $secondName;
    private $secondValue;
    private $helper;
    public function setUp() {
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->name = 'slug';
        $this->value = 'this-is-a-slug';

        $this->secondName = 'title';
        $this->secondValue = 'this-is-a-title';

        $this->helper = new KeynameHelper($this, $this->keynameMock);
    }

    public function tearDown() {

    }

    public function testGetName_Success() {

        $this->helper->expectsGetName_Success($this->name);

        $name = $this->keynameMock->getName();

        $this->assertEquals($this->name, $name);

    }

    public function testGetName_multiple_Success() {

        $this->helper->expectsGetName_multiple_Success([$this->name, $this->secondName]);

        $name = $this->keynameMock->getName();
        $secondName = $this->keynameMock->getName();

        $this->assertEquals($this->name, $name);
        $this->assertEquals($this->secondName, $secondName);

    }

    public function testGetValue_Success() {

        $this->helper->expectsGetValue_Success($this->value);

        $value = $this->keynameMock->getValue();

        $this->assertEquals($this->value, $value);

    }

    public function testGetValue_multiple_Success() {

        $this->helper->expectsGetValue_multiple_Success([$this->value, $this->secondValue]);

        $value = $this->keynameMock->getValue();
        $secondValue = $this->keynameMock->getValue();

        $this->assertEquals($this->value, $value);
        $this->assertEquals($this->secondValue, $secondValue);

    }

}
