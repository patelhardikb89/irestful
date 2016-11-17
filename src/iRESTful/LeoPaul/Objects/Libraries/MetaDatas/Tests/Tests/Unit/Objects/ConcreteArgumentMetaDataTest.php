<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteArgumentMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Exceptions\ArgumentMetaDataException;

final class ConcreteArgumentMetaDataTest extends \PHPUnit_Framework_TestCase {
	private $arrayMetaDataMock;
	private $classMetaData;
	private $name;
	private $position;
	private $isOptional;
	private $isRecursive;
	public function setUp() {

		$this->arrayMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData');
		$this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');

		$this->name = 'myArgument';
		$this->position = rand(0, 100);
		$this->isOptional = (bool) rand(0, 1);
		$this->isRecursive = (bool) rand(0, 1);

	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$argumentMetaData = new ConcreteArgumentMetaData($this->name, $this->position, $this->isOptional, $this->isRecursive);

		$this->assertEquals($this->name, $argumentMetaData->getName());
		$this->assertEquals($this->position, $argumentMetaData->getPosition());
		$this->assertEquals($this->isOptional, $argumentMetaData->isOptional());
		$this->assertEquals($this->isRecursive, $argumentMetaData->isRecursive());
		$this->assertFalse($argumentMetaData->hasClassMetaData());
		$this->assertNull($argumentMetaData->getClassMetaData());
		$this->assertFalse($argumentMetaData->hasArrayMetaData());
		$this->assertNull($argumentMetaData->getArrayMetaData());

	}

	public function testCreate_withArrayMetaData_Success() {

		$argumentMetaData = new ConcreteArgumentMetaData($this->name, $this->position, $this->isOptional, $this->isRecursive, $this->arrayMetaDataMock);

		$this->assertEquals($this->name, $argumentMetaData->getName());
		$this->assertEquals($this->position, $argumentMetaData->getPosition());
		$this->assertEquals($this->isOptional, $argumentMetaData->isOptional());
		$this->assertEquals($this->isRecursive, $argumentMetaData->isRecursive());
		$this->assertFalse($argumentMetaData->hasClassMetaData());
		$this->assertNull($argumentMetaData->getClassMetaData());
		$this->assertTrue($argumentMetaData->hasArrayMetaData());
		$this->assertEquals($this->arrayMetaDataMock, $argumentMetaData->getArrayMetaData());
	}

	public function testCreate_isResursiveIsFalse_withClassMetaData_Success() {

		$argumentMetaData = new ConcreteArgumentMetaData($this->name, $this->position, $this->isOptional, false, null, $this->classMetaDataMock);

		$this->assertEquals($this->name, $argumentMetaData->getName());
		$this->assertEquals($this->position, $argumentMetaData->getPosition());
		$this->assertEquals($this->isOptional, $argumentMetaData->isOptional());
		$this->assertFalse($argumentMetaData->isRecursive());
		$this->assertTrue($argumentMetaData->hasClassMetaData());
		$this->assertEquals($this->classMetaDataMock, $argumentMetaData->getClassMetaData());
		$this->assertFalse($argumentMetaData->hasArrayMetaData());
		$this->assertNull($argumentMetaData->getArrayMetaData());

	}

	public function testCreate_isResursiveIsFalse_withArrayMetaData_withClassMetaData_Success() {

		$argumentMetaData = new ConcreteArgumentMetaData($this->name, $this->position, $this->isOptional, false, $this->arrayMetaDataMock, $this->classMetaDataMock);

		$this->assertEquals($this->name, $argumentMetaData->getName());
		$this->assertEquals($this->position, $argumentMetaData->getPosition());
		$this->assertEquals($this->isOptional, $argumentMetaData->isOptional());
		$this->assertFalse($argumentMetaData->isRecursive());
		$this->assertTrue($argumentMetaData->hasClassMetaData());
		$this->assertEquals($this->classMetaDataMock, $argumentMetaData->getClassMetaData());
		$this->assertTrue($argumentMetaData->hasArrayMetaData());
		$this->assertEquals($this->arrayMetaDataMock, $argumentMetaData->getArrayMetaData());

	}

	public function testCreate_withEmptyName_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArgumentMetaData('', $this->position, $this->isOptional, $this->isRecursive);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringName_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArgumentMetaData(new \DateTime(), $this->position, $this->isOptional, $this->isRecursive);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNegativePosition_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArgumentMetaData($this->name, $this->position * -1, $this->isOptional, $this->isRecursive);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_isRecursive_withClassMetaData_throwsArgumentMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArgumentMetaData($this->name, $this->position, $this->isOptional, true, null, $this->classMetaDataMock);

		} catch (ArgumentMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
