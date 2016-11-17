<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ConcreteClassMetaDataTest extends \PHPUnit_Framework_TestCase {
	private $className;
	private $interfaceName;
	private $constructorMetaDataMock;
	private $arguments;
	private $argumentsWithInvalidElement;
	private $argumentsWithInvalidObject;
	private $containerName;
	public function setUp() {

		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects\ConcreteClassMetaDataTest';
		$this->interfaceName = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface';

		$this->constructorMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData');

		$this->arguments = [
			$this->constructorMetaDataMock,
			$this->constructorMetaDataMock,
			$this->constructorMetaDataMock
		];

		$this->argumentsWithInvalidElement = [
			$this->constructorMetaDataMock,
			'invalid element',
			$this->constructorMetaDataMock
		];

		$this->argumentsWithInvalidObject = [
			$this->constructorMetaDataMock,
			new \DateTime(),
			$this->constructorMetaDataMock
		];

		$this->containerName = 'some_element';
	}

	public function tearDown() {

	}

    public function testCreate_isNotKey_Success() {

		$classMetaData = new ConcreteClassMetaData($this->className, $this->arguments);

		$this->assertEquals($this->className, $classMetaData->getType());
		$this->assertFalse($classMetaData->hasContainerName());
		$this->assertNull($classMetaData->getContainerName());
		$this->assertEquals($this->arguments, $classMetaData->getArguments());

	}

	public function testCreate_withInterfaceName_Success() {

		$classMetaData = new ConcreteClassMetaData($this->interfaceName, $this->arguments);

		$this->assertEquals($this->interfaceName, $classMetaData->getType());
		$this->assertFalse($classMetaData->hasContainerName());
		$this->assertNull($classMetaData->getContainerName());
		$this->assertEquals($this->arguments, $classMetaData->getArguments());

	}

	public function testCreate_withInvalidType_Success() {

		$asserted = false;
		try {

			new ConcreteClassMetaData('not a valid type', $this->arguments);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyType_Success() {

		$asserted = false;
		try {

			new ConcreteClassMetaData('', $this->arguments);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringType_Success() {

		$asserted = false;
		try {

			new ConcreteClassMetaData(new \DateTime(), $this->arguments);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidElement_throwsClassMetaDataException() {

		$asserted = false;
		try {

			new ConcreteClassMetaData($this->className, $this->argumentsWithInvalidElement);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidObject_throwsClassMetaDataException() {

		$asserted = false;
		try {

			new ConcreteClassMetaData($this->className, $this->argumentsWithInvalidObject);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withContainerName_Success() {

		$classMetaData = new ConcreteClassMetaData($this->className, $this->arguments, $this->containerName);

		$this->assertEquals($this->className, $classMetaData->getType());
		$this->assertTrue($classMetaData->hasContainerName());
		$this->assertEquals($this->containerName, $classMetaData->getContainerName());
		$this->assertEquals($this->arguments, $classMetaData->getArguments());

	}

	public function testCreate_withEmptyContainerName_Success() {

		$classMetaData = new ConcreteClassMetaData($this->className, $this->arguments, '');

		$this->assertEquals($this->className, $classMetaData->getType());
		$this->assertFalse($classMetaData->hasContainerName());
		$this->assertNull($classMetaData->getContainerName());
		$this->assertEquals($this->arguments, $classMetaData->getArguments());

	}

    public function testCreate_withNonStringContainerName_throwsClassMetaDataException() {

		$asserted = false;
		try {

			new ConcreteClassMetaData($this->className, $this->arguments, new \DateTime());

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
