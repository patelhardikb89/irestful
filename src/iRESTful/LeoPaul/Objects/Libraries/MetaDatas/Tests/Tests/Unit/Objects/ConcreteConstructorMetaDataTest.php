<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Exceptions\ConstructorMetaDataException;

final class ConcreteConstructorMetaDataTest extends \PHPUnit_Framework_TestCase {
	private $argumentMetaDataMock;
	private $transformerMock;
	private $methodName;
	private $keyname;
	private $humanMethodName;
	public function setUp() {
		$this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
		$this->transformerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer');
		$this->methodName = 'myMethod';
		$this->keyname = 'my_keyname';
		$this->humanMethodName = 'myHumanMethod';
	}

	public function tearDown() {

	}

    public function testCreate_isKey_isUnique_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, true, $this->methodName, $this->keyname);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertTrue($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertFalse($constructorMetaData->hasDefault());
        $this->assertNull($constructorMetaData->getDefault());
	}

    public function testCreate_isNotKey_isUnique_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, false, true, $this->methodName, $this->keyname);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertFalse($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertFalse($constructorMetaData->hasDefault());
        $this->assertNull($constructorMetaData->getDefault());
	}

    public function testCreate_isKey_isNotUnique_mustBeUnique_withDefault_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, false, $this->methodName, $this->keyname, null, null, 'null');

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertTrue($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertTrue($constructorMetaData->hasDefault());
        $this->assertEquals('null', $constructorMetaData->getDefault());
	}

    public function testCreate_isNotKey_isNotUnique_withDefault_Success() {

        $default = rand(0, 100);

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, false, false, $this->methodName, $this->keyname, null, null, $default);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertFalse($constructorMetaData->isKey());
        $this->assertFalse($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertTrue($constructorMetaData->hasDefault());
        $this->assertEquals($default, $constructorMetaData->getDefault());
	}

    public function testCreate_isNotKey_isNotUnique_withZeroDefault_Success() {

        $default = 0;

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, false, false, $this->methodName, $this->keyname, null, null, $default);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertFalse($constructorMetaData->isKey());
        $this->assertFalse($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertTrue($constructorMetaData->hasDefault());
        $this->assertEquals($default, $constructorMetaData->getDefault());
	}

    public function testCreate_isNotKey_isNotUnique_withStringDefault_Success() {

        $default = 'my default';

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, false, false, $this->methodName, $this->keyname, null, null, $default);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertFalse($constructorMetaData->isKey());
        $this->assertFalse($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertTrue($constructorMetaData->hasDefault());
        $this->assertEquals($default, $constructorMetaData->getDefault());
	}

    public function testCreate_isNotKey_isNotUnique_withFloatDefault_Success() {

        $default = (float) 100/1024;

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, false, false, $this->methodName, $this->keyname, null, null, $default);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertFalse($constructorMetaData->isKey());
        $this->assertFalse($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
        $this->assertTrue($constructorMetaData->hasDefault());
        $this->assertEquals($default, $constructorMetaData->getDefault());
	}

	public function testCreate_withEmptyKeyname_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, true, $this->methodName, '');

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testCreate_withNonStringKeyname_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, true,  true, $this->methodName, new \DateTime());

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testCreate_withEmptyMethodName_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, true,  true, '', $this->keyname);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testCreate_withNonStringMethodName_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, true,  true, new \DateTime(), $this->keyname);

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

    public function testCreate_withNonStringHumanMethodName_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, true,  true, $this->methodName, $this->keyname, new \DateTime());

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

    public function testCreate_withNonBooleanKey_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, new \DateTime(),  true, $this->methodName, $this->keyname, new \DateTime());

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

    public function testCreate_withNonBooleanUnique_throwsConstructorMetaDataException() {

		$asserted = false;
		try {

			new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, new \DateTime(), $this->methodName, $this->keyname, new \DateTime());

		} catch (ConstructorMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testCreate_withEmptyHumanMethodName_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, true, $this->methodName, $this->keyname, '');

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertTrue($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
	}

	public function testCreate_withHumanMethodName_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, true, $this->methodName, $this->keyname, $this->humanMethodName);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertTrue($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertTrue($constructorMetaData->hasHumanMethodName());
		$this->assertEquals($this->humanMethodName, $constructorMetaData->getHumanMethodName());
		$this->assertFalse($constructorMetaData->hasTransformer());
		$this->assertNull($constructorMetaData->getTransformer());
	}

	public function testCreate_withTransformer_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, true, $this->methodName, $this->keyname, null, $this->transformerMock);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertTrue($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertFalse($constructorMetaData->hasHumanMethodName());
		$this->assertNull($constructorMetaData->getHumanMethodName());
		$this->assertTrue($constructorMetaData->hasTransformer());
		$this->assertEquals($this->transformerMock, $constructorMetaData->getTransformer());
	}

	public function testCreate_withHumanMethodName_withTransformer_Success() {

		$constructorMetaData = new ConcreteConstructorMetaData($this->argumentMetaDataMock, true, true, $this->methodName, $this->keyname, $this->humanMethodName, $this->transformerMock);

		$this->assertEquals($this->argumentMetaDataMock, $constructorMetaData->getArgumentMetaData());
        $this->assertTrue($constructorMetaData->isKey());
        $this->assertTrue($constructorMetaData->isUnique());
		$this->assertEquals($this->methodName, $constructorMetaData->getMethodName());
		$this->assertEquals($this->keyname, $constructorMetaData->getKeyname());
		$this->assertTrue($constructorMetaData->hasHumanMethodName());
		$this->assertEquals($this->humanMethodName, $constructorMetaData->getHumanMethodName());
		$this->assertTrue($constructorMetaData->hasTransformer());
		$this->assertEquals($this->transformerMock, $constructorMetaData->getTransformer());
	}

}
