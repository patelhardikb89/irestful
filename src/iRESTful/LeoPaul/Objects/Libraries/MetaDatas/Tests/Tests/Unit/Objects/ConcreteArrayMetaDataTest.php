<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteArrayMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;

final class ConcreteArrayMetaDataTest extends \PHPUnit_Framework_TestCase {
    private $transformerMock;
	private $elementsType;
	public function setUp() {
        $this->transformerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer');
		$this->elementsType = get_class($this);
	}

	public function tearDown() {

	}

    public function testCreate_Success() {

		$arrayMetaData = new ConcreteArrayMetaData();

		$this->assertFalse($arrayMetaData->hasElementsType());
		$this->assertNull($arrayMetaData->getElementsType());
        $this->assertFalse($arrayMetaData->hasTransformers());
        $this->assertNull($arrayMetaData->getToObjectTransformer());
        $this->assertNull($arrayMetaData->getToDataTransformer());
	}

	public function testCreate_withEmptyElementsType_Success() {

		$arrayMetaData = new ConcreteArrayMetaData('');

		$this->assertFalse($arrayMetaData->hasElementsType());
		$this->assertNull($arrayMetaData->getElementsType());
        $this->assertFalse($arrayMetaData->hasTransformers());
        $this->assertNull($arrayMetaData->getToObjectTransformer());
        $this->assertNull($arrayMetaData->getToDataTransformer());
	}

	public function testCreate_withElementsType_Success() {

		$arrayMetaData = new ConcreteArrayMetaData($this->elementsType);

		$this->assertTrue($arrayMetaData->hasElementsType());
		$this->assertEquals($this->elementsType, $arrayMetaData->getElementsType());
        $this->assertFalse($arrayMetaData->hasTransformers());
        $this->assertNull($arrayMetaData->getToObjectTransformer());
        $this->assertNull($arrayMetaData->getToDataTransformer());
	}

    public function testCreate_withTransformers_Success() {

		$arrayMetaData = new ConcreteArrayMetaData(null, $this->transformerMock, $this->transformerMock);

		$this->assertFalse($arrayMetaData->hasElementsType());
		$this->assertNull($arrayMetaData->getElementsType());
        $this->assertTrue($arrayMetaData->hasTransformers());
        $this->assertEquals($this->transformerMock, $arrayMetaData->getToObjectTransformer());
        $this->assertEquals($this->transformerMock, $arrayMetaData->getToDataTransformer());
	}

	public function testCreate_withInvalidElementsType_Success() {

		$asserted = false;
		try {

			new ConcreteArrayMetaData('not a valid class');

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testCreate_withNonStringElementsType_throwsArrayMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArrayMetaData(new \DateTime());

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

    public function testCreate_withToObjectTransformer_withoutToDataTransformer_throwsArrayMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArrayMetaData(null, $this->transformerMock);

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

    public function testCreate_withToDataTransformer_withoutToObjectTransformer_throwsArrayMetaDataException() {

		$asserted = false;
		try {

			new ConcreteArrayMetaData(null, null, $this->transformerMock);

		} catch (ArrayMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

}
