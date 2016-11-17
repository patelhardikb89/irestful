<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTransformer;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;

final class ConcreteTransformerTest extends \PHPUnit_Framework_TestCase {
	private $interfaceName;
	private $className;
	private $methodName;
	public function setUp() {
		$this->interfaceName = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Adapters\ClassMetaDataAdapter';
		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteClassMetaDataAdapter';
		$this->methodName = 'fromDataToClassMetaData';
	}

	public function tearDown() {

	}

	public function testCreate_withClassName_Success() {

		$transformer = new ConcreteTransformer($this->className, $this->methodName);

		$this->assertEquals($this->className, $transformer->getType());
		$this->assertEquals($this->methodName, $transformer->getMethodName());

	}

	public function testCreate_withInterfaceName_Success() {

		$transformer = new ConcreteTransformer($this->interfaceName, $this->methodName);

		$this->assertEquals($this->interfaceName, $transformer->getType());
		$this->assertEquals($this->methodName, $transformer->getMethodName());

	}

	public function testCreate_withInterfaceName_withInvalidMethodName_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer($this->interfaceName, 'invalidMethod');

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withClassName_withInvalidMethodName_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer($this->className, 'invalidMethod');

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidType_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer('InvalidClass', $this->methodName);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyType_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer('', $this->methodName);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringType_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer(new \DateTime(), $this->methodName);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyMethodName_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer($this->className, '');

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringMethodName_throwsTransformerException() {

		$asserted = false;
		try {

			new ConcreteTransformer($this->className, new \DateTime());

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
