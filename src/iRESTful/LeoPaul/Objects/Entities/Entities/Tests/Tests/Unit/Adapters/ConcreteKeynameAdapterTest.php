<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;

final class ConcreteKeynameAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $datas;
    private $adapter;
    public function setUp() {
        $this->data = [
            'name' => 'slug',
            'value' => 'this-is-a-slug'
        ];

        $this->datas = [
            [
                'name' => 'slug',
                'value' => 'this-is-a-slug'
            ],
            [
                'name' => 'uuid',
                'value' => '5677be55-16ff-40c3-bc76-d4445f9c40e4'
            ]
        ];

        $this->adapter = new ConcreteKeynameAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToKeyname_Success() {

        $keyname = $this->adapter->fromDataToKeyname($this->data);

        $this->assertEquals($this->data['name'], $keyname->getName());
        $this->assertEquals($this->data['value'], $keyname->getValue());
    }

    public function testFromDataToKeyname_withoutName_throwsKeynameException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToKeyname($this->data);

        } catch (KeynameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToKeyname_withoutValue_throwsKeynameException() {

        unset($this->data['value']);

        $asserted = false;
        try {

            $this->adapter->fromDataToKeyname($this->data);

        } catch (KeynameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToKeynames_Success() {

        $keynames = $this->adapter->fromDataToKeynames($this->datas);

        $this->assertEquals(2, count($keynames));
        $this->assertEquals($this->datas[0]['name'], $keynames[0]->getName());
        $this->assertEquals($this->datas[0]['value'], $keynames[0]->getValue());
        $this->assertEquals($this->datas[1]['name'], $keynames[1]->getName());
        $this->assertEquals($this->datas[1]['value'], $keynames[1]->getValue());
    }

}
