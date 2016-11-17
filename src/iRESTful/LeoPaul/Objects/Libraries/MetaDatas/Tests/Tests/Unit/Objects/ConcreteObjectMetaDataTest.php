<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteObjectMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\MasterObject;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SecondObject;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ThirdObject;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\Exceptions\ObjectMetaDataException;

final class ConcreteObjectMetaDataTest extends \PHPUnit_Framework_TestCase {
	private $masterTitle;
	private $secondTitle;
	private $thirdTitle;
	private $master;
	private $second;
	private $third;
	public function setUp() {

		$this->masterTitle = 'master title';
		$this->secondTitle = 'second title';
		$this->thirdTitle = 'third title';

		$this->third = new ThirdObject($this->thirdTitle);
		$this->second = new SecondObject($this->secondTitle, $this->third);
		$this->master = new MasterObject($this->masterTitle, $this->second);

	}

	public function tearDown() {

	}

    public function testCreate_Success() {

		$objectMetaData = new ConcreteObjectMetaData($this->master);

		$this->assertEquals($this->master, $objectMetaData->getObject());
		$this->assertEquals($this->masterTitle, $objectMetaData->call('getTitle()'));
		$this->assertEquals($this->second, $objectMetaData->call('getSecond()'));
		$this->assertEquals($this->secondTitle, $objectMetaData->call('getSecond()->getTitle()'));
		$this->assertEquals($this->third, $objectMetaData->call('getSecond()->getThird()'));
		$this->assertEquals($this->thirdTitle, $objectMetaData->call('getSecond()->getThird()->getTitle()'));

	}

    public function testCreate_objectIsNullButThereIsAMethod_returnsNull_Success() {

		$objectMetaData = new ConcreteObjectMetaData($this->master);
        
		$this->assertNull($objectMetaData->call('getLast()->get()'));

	}

	public function testCreate_withInvalidObject_Success() {

		$asserted = false;
		try {

			new ConcreteObjectMetaData('not an object');

		} catch (ObjectMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_call_withInvalidMethod_firstLevel_throwsObjectMetaDataException() {

		$objectMetaData = new ConcreteObjectMetaData($this->master);

		$asserted = false;
		try {

			$this->assertEquals($this->masterTitle, $objectMetaData->call('getInvalidMethod()()'));

		} catch (ObjectMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_call_withInvalidMethod_firstSecond_throwsObjectMetaDataException() {

		$objectMetaData = new ConcreteObjectMetaData($this->master);

		$asserted = false;
		try {

			$this->assertEquals($this->masterTitle, $objectMetaData->call('getSecond()->getInvalidMethod()'));

		} catch (ObjectMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
