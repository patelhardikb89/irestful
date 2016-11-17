<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers\ConcreteTransformerWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\TransformerHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteTransformerWrapperTest extends \PHPUnit_Framework_TestCase {
	private $transformerMock;
	private $uuidAdapterMock;
	private $transformerObjects;
	private $uuidMock;
	private $type;
	private $methodName;
	private $uuid;
	private $wrapper;
	private $transformerHelper;
	private $uuidAdapterHelper;
	public function setUp() {

		$this->type = 'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter';

		$this->transformerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Transformer');
		$this->uuidAdapterMock = $this->createMock($this->type);
		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

		$this->transformerObjects = [
			$this->type => $this->uuidAdapterMock
		];

		$this->methodName = 'fromStringToUuid';
		$this->uuid = '81041c78-c8f5-4212-ab07-a8eb7839f896';

		$this->wrapper = new ConcreteTransformerWrapper($this->transformerObjects, $this->transformerMock);

		$this->transformerHelper = new TransformerHelper($this, $this->transformerMock);
		$this->uuidAdapterHelper = new UuidAdapterHelper($this, $this->uuidAdapterMock);
	}

	public function tearDown() {

	}

	public function testTransform_Success() {

		$this->transformerHelper->expectsGetType_Success($this->type);
		$this->transformerHelper->expectsGetMethodName_Success($this->methodName);
		$this->uuidAdapterHelper->expectsFromStringToUuid_Success($this->uuidMock, $this->uuid);

		$transformed = $this->wrapper->transform($this->uuid);

		$this->assertEquals($this->uuidMock, $transformed);

	}

	public function testTransform_throwsExceptionInTransformation_throwsTransformerException() {

		$this->transformerHelper->expectsGetType_Success($this->type);
		$this->transformerHelper->expectsGetMethodName_Success($this->methodName);
		$this->uuidAdapterHelper->expectsFromStringToUuid_throwsUuidException($this->uuid);

		$asserted = false;
		try {

			$this->wrapper->transform($this->uuid);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withInvalidMethodName_throwsReflectionException_throwsTransformerException() {

		$this->transformerHelper->expectsGetType_Success($this->type);
		$this->transformerHelper->expectsGetMethodName_Success('invalidMethod');

		$asserted = false;
		try {

			$this->wrapper->transform($this->uuid);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testTransform_withTypeNotInTransformerObjects_throwsTransformerException() {

		$this->transformerHelper->expectsGetType_Success('\DateTime');

		$asserted = false;
		try {

			$this->wrapper->transform($this->uuid);

		} catch (TransformerException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
