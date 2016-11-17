<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Functional\Repositories;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use  iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassMetaDataRepositoryFactory;

final class ReflectionClassMetaDataRepositoryTest extends \PHPUnit_Framework_TestCase {
	private $simpleEntityClassName;
	private $simpleEntityContainerName;
	private $complexEntityClassName;
	private $complexEntityContainerName;
	private $classWithoutContainerName;
	private $classWithoutConstructor;
	private $classWithoutConstructorAnnotations;
	private $classWithInvalidConstructorAnnotation;
	private $repository;
	private $repositoryWithoutMapper;
	public function setUp() {

		$this->simpleEntityClassName = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity';
		$this->simpleEntityContainerName = 'simple_entity';

		$this->complexEntityClassName = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntity';
		$this->complexEntityContainerName = 'complex_entity';

		$this->classWithoutContainerName = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntityWithoutContainerName';

		$this->classWithoutConstructor = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\Invalids\ClassWithoutConstructor';
		$this->classWithoutConstructorAnnotations = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\Invalids\ClassWithoutConstructorAnnotations';
		$this->classWithInvalidConstructorAnnotation = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\Invalids\ClassWithInvalidConstructorAnnotation';

		$containerClassMapper = [
			$this->complexEntityContainerName => $this->complexEntityClassName,
			$this->simpleEntityContainerName => $this->simpleEntityClassName
		];

		$interfaceClassMapper = [
			'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity',
            'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapter'
		];

        $factory = new ReflectionClassMetaDataRepositoryFactory($containerClassMapper, $interfaceClassMapper);
        $factoryWithoutMapper = new ReflectionClassMetaDataRepositoryFactory([], []);

		$this->repository = $factory->create();
		$this->repositoryWithoutMapper = $factoryWithoutMapper->create();
	}

	public function tearDown() {

	}

	public function testRetrieveSimpleEntity_withClassName_Success() {
		$metaData = $this->repository->retrieve(['class' => $this->simpleEntityClassName]);

		$this->validateSimpleEntity($metaData);
	}

	public function testRetrieveSimpleEntity_withClassName_twice_Success() {
		$firstMetaData = $this->repository->retrieve(['class' => $this->simpleEntityClassName]);
		$secondMetaData = $this->repository->retrieve(['class' => $this->simpleEntityClassName]);
		$this->validateSimpleEntity($firstMetaData);
		$this->validateSimpleEntity($secondMetaData);
	}

	public function testRetrieveSimpleEntity_withContainerName_Success() {
		$metaData = $this->repository->retrieve(['container' => $this->simpleEntityContainerName]);
		$this->validateSimpleEntity($metaData);
	}

	public function testRetrieveComplexEntity_withClassName_Success() {

		$metaData = $this->repository->retrieve(['class' => $this->complexEntityClassName]);
		$this->validateComplexEntityWithContainerName($metaData);
	}

	public function testRetrieveComplexEntity_withContainerName_Success() {

		$metaData = $this->repository->retrieve(['container' => $this->complexEntityContainerName]);
		$this->validateComplexEntityWithContainerName($metaData);
	}

	public function testRetrieveComplexEntity_withClassName_classHasNoContainer_Success() {

		$metaData = $this->repository->retrieve(['class' => $this->classWithoutContainerName]);
		$this->validateComplexEntityWithoutContainer($metaData);
	}

	public function testRetrieveByContainer_containerNotInMapper_throwsClassMetaDataException() {

		$asserted = false;
		try {

			$this->repositoryWithoutMapper->retrieve(['container' => $this->simpleEntityContainerName]);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testRetrieve_withoutRetrieverCriteria_throwsClassMetaDataException() {

		$asserted = false;
		try {

			$this->repositoryWithoutMapper->retrieve([]);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testRetrieveByClassName_classHasNoConstructor_throwsClassMetaDataException() {

		$asserted = false;
		try {

			$this->repositoryWithoutMapper->retrieve(['class' => $this->classWithoutConstructor]);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testRetrieveByClassName_classHasNoConstructorAnnotations_throwsClassMetaDataException() {

		$asserted = false;
		try {

			$this->repositoryWithoutMapper->retrieve(['class' => $this->classWithoutConstructorAnnotations]);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testRetrieveByClassName_classWithInvalidConstructorAnnotation_throwsClassMetaDataException() {

		$asserted = false;
		try {

			$this->repositoryWithoutMapper->retrieve(['class' => $this->classWithInvalidConstructorAnnotation]);

		} catch (ClassMetaDataException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	private function validateSimpleEntity(ClassMetaData $simpleEntity) {
		$arguments = $simpleEntity->getArguments();
		$this->assertEquals($this->simpleEntityContainerName, $simpleEntity->getContainerName());

		$this->assertTrue(isset($arguments['uuid']));
        $this->assertTrue($arguments['uuid']->isKey());
		$this->assertEquals('uuid', $arguments['uuid']->getArgumentMetaData()->getName());
        $this->assertTrue($arguments['uuid']->isKey());
        $this->assertTrue($arguments['uuid']->isUnique());
        $this->assertFalse($arguments['uuid']->hasDefault());
        $this->assertNull($arguments['uuid']->getDefault());
        $this->assertTrue($arguments['uuid']->hasType());
        $this->assertTrue($arguments['uuid']->getType()->hasBinary());
        $this->assertTrue($arguments['uuid']->getType()->getBinary()->hasSpecificBitSize());
        $this->assertEquals(128, $arguments['uuid']->getType()->getBinary()->getSpecificBitSize());
		$this->assertEquals(0, $arguments['uuid']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['uuid']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['uuid']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getUuid()->get()', $arguments['uuid']->getMethodName());
		$this->assertEquals('uuid', $arguments['uuid']->getKeyname());
		$this->assertTrue($arguments['uuid']->hasHumanMethodName());
		$this->assertEquals('getUuid()->getHumanReadable()', $arguments['uuid']->getHumanMethodName());
		$this->assertTrue($arguments['uuid']->hasTransformer());
		$this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter', $arguments['uuid']->getTransformer()->getType());
		$this->assertEquals('fromStringToUuid', $arguments['uuid']->getTransformer()->getMethodName());

		$this->assertTrue(isset($arguments['createdOn']));
        $this->assertFalse($arguments['createdOn']->isKey());
        $this->assertFalse($arguments['createdOn']->isUnique());
        $this->assertFalse($arguments['createdOn']->hasDefault());
        $this->assertNull($arguments['createdOn']->getDefault());
        $this->assertTrue($arguments['createdOn']->hasType());
        $this->assertTrue($arguments['createdOn']->getType()->hasInteger());
        $this->assertEquals(64, $arguments['createdOn']->getType()->getInteger()->getMaximumBitSize());
		$this->assertEquals('createdOn', $arguments['createdOn']->getArgumentMetaData()->getName());
		$this->assertEquals(1, $arguments['createdOn']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['createdOn']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['createdOn']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('createdOn()->getTimestamp()', $arguments['createdOn']->getMethodName());
		$this->assertEquals('created_on', $arguments['createdOn']->getKeyname());
		$this->assertFalse($arguments['createdOn']->hasHumanMethodName());
		$this->assertNull($arguments['createdOn']->getHumanMethodName());
		$this->assertTrue($arguments['createdOn']->hasTransformer());
		$this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter', $arguments['createdOn']->getTransformer()->getType());
		$this->assertEquals('fromTimestampToDateTime', $arguments['createdOn']->getTransformer()->getMethodName());

		$this->assertTrue(isset($arguments['title']));
        $this->assertFalse($arguments['title']->isKey());
        $this->assertFalse($arguments['title']->isUnique());
        $this->assertTrue($arguments['title']->hasDefault());
        $this->assertEquals('my-title', $arguments['title']->getDefault());
        $this->assertTrue($arguments['title']->hasType());
        $this->assertTrue($arguments['title']->getType()->hasString());
        $this->assertTrue($arguments['title']->getType()->getString()->hasSpecificCharacterSize());
        $this->assertEquals(255, $arguments['title']->getType()->getString()->getSpecificCharacterSize());
		$this->assertEquals('title', $arguments['title']->getArgumentMetaData()->getName());
		$this->assertEquals(2, $arguments['title']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['title']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['title']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getTitle()', $arguments['title']->getMethodName());
		$this->assertEquals('title', $arguments['title']->getKeyname());
		$this->assertFalse($arguments['title']->hasHumanMethodName());
		$this->assertNull($arguments['title']->getHumanMethodName());
		$this->assertFalse($arguments['title']->hasTransformer());
		$this->assertNull($arguments['title']->getTransformer());

        $this->assertTrue(isset($arguments['slug']));
        $this->assertFalse($arguments['slug']->isKey());
        $this->assertTrue($arguments['slug']->isUnique());
        $this->assertTrue($arguments['slug']->hasDefault());
        $this->assertTrue($arguments['slug']->hasType());
        $this->assertTrue($arguments['slug']->getType()->hasString());
        $this->assertTrue($arguments['slug']->getType()->getString()->hasSpecificCharacterSize());
        $this->assertEquals(255, $arguments['slug']->getType()->getString()->getSpecificCharacterSize());
        $this->assertEquals('my-slug', $arguments['slug']->getDefault());
		$this->assertEquals('slug', $arguments['slug']->getArgumentMetaData()->getName());
		$this->assertEquals(3, $arguments['slug']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['slug']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['slug']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['slug']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['slug']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['slug']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['slug']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getSlug()', $arguments['slug']->getMethodName());
		$this->assertEquals('slug', $arguments['slug']->getKeyname());
		$this->assertFalse($arguments['slug']->hasHumanMethodName());
		$this->assertNull($arguments['slug']->getHumanMethodName());
		$this->assertFalse($arguments['slug']->hasTransformer());
		$this->assertNull($arguments['slug']->getTransformer());

        $this->assertTrue(isset($arguments['domainNames']));
        $this->assertFalse($arguments['domainNames']->isKey());
        $this->assertFalse($arguments['domainNames']->isUnique());
        $this->assertFalse($arguments['domainNames']->hasDefault());
        $this->assertNull($arguments['domainNames']->getDefault());
        $this->assertTrue($arguments['domainNames']->hasType());
        $this->assertTrue($arguments['domainNames']->getType()->hasString());
        $this->assertTrue($arguments['domainNames']->getType()->getString()->hasSpecificCharacterSize());
        $this->assertEquals(255, $arguments['domainNames']->getType()->getString()->getSpecificCharacterSize());
		$this->assertEquals('domainNames', $arguments['domainNames']->getArgumentMetaData()->getName());
		$this->assertEquals(4, $arguments['domainNames']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['domainNames']->getArgumentMetaData()->isRecursive());
		$this->assertTrue($arguments['domainNames']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['domainNames']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['domainNames']->getArgumentMetaData()->getClassMetaData());
		$this->assertTrue($arguments['domainNames']->getArgumentMetaData()->hasArrayMetaData());
        $this->assertTrue($arguments['domainNames']->getArgumentMetaData()->getArrayMetaData()->hasTransformers());
        $this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface', $arguments['domainNames']->getArgumentMetaData()->getArrayMetaData()->getToObjectTransformer()->getType());
        $this->assertEquals('fromStringToDomainNames', $arguments['domainNames']->getArgumentMetaData()->getArrayMetaData()->getToObjectTransformer()->getMethodName());
        $this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface', $arguments['domainNames']->getArgumentMetaData()->getArrayMetaData()->getToDataTransformer()->getType());
        $this->assertEquals('fromDomainNamesToString', $arguments['domainNames']->getArgumentMetaData()->getArrayMetaData()->getToDataTransformer()->getMethodName());
		$this->assertEquals('getDomainNames()', $arguments['domainNames']->getMethodName());
		$this->assertEquals('domain_names', $arguments['domainNames']->getKeyname());
		$this->assertFalse($arguments['domainNames']->hasHumanMethodName());
		$this->assertNull($arguments['domainNames']->getHumanMethodName());
		$this->assertFalse($arguments['domainNames']->hasTransformer());
		$this->assertNull($arguments['domainNames']->getTransformer());

        $this->assertTrue(isset($arguments['float']));
        $this->assertFalse($arguments['float']->isKey());
        $this->assertFalse($arguments['float']->isUnique());
        $this->assertTrue($arguments['float']->hasDefault());
        $this->assertEquals('null', $arguments['float']->getDefault());
        $this->assertTrue($arguments['float']->hasType());
        $this->assertTrue($arguments['float']->getType()->hasFloat());
        $this->assertEquals(20, $arguments['float']->getType()->getFloat()->getDigitsAmount());
        $this->assertEquals(3, $arguments['float']->getType()->getFloat()->getPrecision());
        $this->assertEquals('float', $arguments['float']->getArgumentMetaData()->getName());
		$this->assertEquals(5, $arguments['float']->getArgumentMetaData()->getPosition());
        $this->assertFalse($arguments['float']->getArgumentMetaData()->isRecursive());
		$this->assertTrue($arguments['float']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['float']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['float']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['float']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['float']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getFloat()', $arguments['float']->getMethodName());
		$this->assertEquals('float', $arguments['float']->getKeyname());
		$this->assertFalse($arguments['float']->hasHumanMethodName());
		$this->assertNull($arguments['float']->getHumanMethodName());
		$this->assertFalse($arguments['float']->hasTransformer());
		$this->assertNull($arguments['float']->getTransformer());
	}

	private function validateBigProperty(ClassMetaData $bigProperty) {

		$arguments = $bigProperty->getArguments();

		$this->assertFalse($bigProperty->hasContainerName());
		$this->assertNull($bigProperty->getContainerName());

        $this->assertTrue(isset($arguments['title']));
        $this->assertFalse($arguments['title']->isKey());
        $this->assertFalse($arguments['title']->isUnique());
        $this->assertFalse($arguments['title']->hasDefault());
        $this->assertNull($arguments['title']->getDefault());
        $this->assertTrue($arguments['title']->hasType());
        $this->assertTrue($arguments['title']->getType()->hasString());
        $this->assertTrue($arguments['title']->getType()->getString()->hasSpecificCharacterSize());
        $this->assertEquals(255, $arguments['title']->getType()->getString()->getSpecificCharacterSize());
		$this->assertEquals('title', $arguments['title']->getArgumentMetaData()->getName());
		$this->assertEquals(0, $arguments['title']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['title']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['title']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getTitle()', $arguments['title']->getMethodName());
		$this->assertEquals('title', $arguments['title']->getKeyname());
		$this->assertFalse($arguments['title']->hasHumanMethodName());
		$this->assertNull($arguments['title']->getHumanMethodName());
		$this->assertFalse($arguments['title']->hasTransformer());
		$this->assertNull($arguments['title']->getTransformer());

        $this->assertTrue(isset($arguments['isGood']));
        $this->assertFalse($arguments['isGood']->isKey());
        $this->assertFalse($arguments['isGood']->isUnique());
        $this->assertFalse($arguments['isGood']->hasDefault());
        $this->assertNull($arguments['isGood']->getDefault());
        $this->assertTrue($arguments['isGood']->hasType());
        $this->assertTrue($arguments['isGood']->getType()->isBoolean());
		$this->assertEquals('isGood', $arguments['isGood']->getArgumentMetaData()->getName());
		$this->assertEquals(1, $arguments['isGood']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['isGood']->getArgumentMetaData()->isRecursive());
		$this->assertTrue($arguments['isGood']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['isGood']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['isGood']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['isGood']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['isGood']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('isGood()', $arguments['isGood']->getMethodName());
		$this->assertEquals('is_good', $arguments['isGood']->getKeyname());
		$this->assertFalse($arguments['isGood']->hasHumanMethodName());
		$this->assertNull($arguments['isGood']->getHumanMethodName());
		$this->assertFalse($arguments['isGood']->hasTransformer());
		$this->assertNull($arguments['isGood']->getTransformer());
	}

	private function validateComplexEntityWithoutContainer(ClassMetaData $complexEntity) {
		$this->assertFalse($complexEntity->hasContainerName());
		$this->assertNull($complexEntity->getContainerName());

		$this->validateComplexEntity($complexEntity);
	}

	private function validateComplexEntityWithContainerName(ClassMetaData $complexEntity) {
		$this->assertTrue($complexEntity->hasContainerName());
		$this->assertEquals($this->complexEntityContainerName, $complexEntity->getContainerName());
		$this->validateComplexEntity($complexEntity);
	}

	private function validateComplexEntity(ClassMetaData $complexEntity) {
		$arguments = $complexEntity->getArguments();

		$this->assertTrue(isset($arguments['uuid']));
        $this->assertTrue($arguments['uuid']->isKey());
        $this->assertTrue($arguments['uuid']->isUnique());
        $this->assertFalse($arguments['uuid']->hasDefault());
        $this->assertNull($arguments['uuid']->getDefault());
        $this->assertTrue($arguments['uuid']->hasType());
        $this->assertTrue($arguments['uuid']->getType()->hasBinary());
        $this->assertTrue($arguments['uuid']->getType()->getBinary()->hasSpecificBitSize());
        $this->assertEquals(128, $arguments['uuid']->getType()->getBinary()->getSpecificBitSize());
		$this->assertEquals('uuid', $arguments['uuid']->getArgumentMetaData()->getName());
		$this->assertEquals(0, $arguments['uuid']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['uuid']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['uuid']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['uuid']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getUuid()->get()', $arguments['uuid']->getMethodName());
		$this->assertEquals('uuid', $arguments['uuid']->getKeyname());
		$this->assertTrue($arguments['uuid']->hasHumanMethodName());
		$this->assertEquals('getUuid()->getHumanReadable()', $arguments['uuid']->getHumanMethodName());
		$this->assertTrue($arguments['uuid']->hasTransformer());
		$this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter', $arguments['uuid']->getTransformer()->getType());
		$this->assertEquals('fromStringToUuid', $arguments['uuid']->getTransformer()->getMethodName());

		$this->assertTrue(isset($arguments['createdOn']));
        $this->assertFalse($arguments['createdOn']->isKey());
        $this->assertFalse($arguments['createdOn']->isUnique());
        $this->assertFalse($arguments['createdOn']->hasDefault());
        $this->assertNull($arguments['createdOn']->getDefault());
        $this->assertTrue($arguments['createdOn']->hasType());
        $this->assertTrue($arguments['createdOn']->getType()->hasInteger());
        $this->assertEquals(64, $arguments['createdOn']->getType()->getInteger()->getMaximumBitSize());
		$this->assertEquals('createdOn', $arguments['createdOn']->getArgumentMetaData()->getName());
		$this->assertEquals(1, $arguments['createdOn']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['createdOn']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['createdOn']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['createdOn']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('createdOn()->getTimestamp()', $arguments['createdOn']->getMethodName());
		$this->assertEquals('created_on', $arguments['createdOn']->getKeyname());
		$this->assertFalse($arguments['createdOn']->hasHumanMethodName());
		$this->assertNull($arguments['createdOn']->getHumanMethodName());
		$this->assertTrue($arguments['createdOn']->hasTransformer());
		$this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter', $arguments['createdOn']->getTransformer()->getType());
		$this->assertEquals('fromTimestampToDateTime', $arguments['createdOn']->getTransformer()->getMethodName());

		$this->assertTrue(isset($arguments['title']));
        $this->assertFalse($arguments['title']->isKey());
        $this->assertTrue($arguments['title']->isUnique());
        $this->assertFalse($arguments['title']->hasDefault());
        $this->assertNull($arguments['title']->getDefault());
        $this->assertTrue($arguments['title']->hasType());
        $this->assertTrue($arguments['title']->getType()->hasString());
        $this->assertTrue($arguments['title']->getType()->getString()->hasSpecificCharacterSize());
        $this->assertEquals(255, $arguments['title']->getType()->getString()->getSpecificCharacterSize());
		$this->assertEquals('title', $arguments['title']->getArgumentMetaData()->getName());
		$this->assertEquals(2, $arguments['title']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['title']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['title']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['title']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getTitle()', $arguments['title']->getMethodName());
		$this->assertEquals('title', $arguments['title']->getKeyname());
		$this->assertFalse($arguments['title']->hasHumanMethodName());
		$this->assertNull($arguments['title']->getHumanMethodName());
		$this->assertFalse($arguments['title']->hasTransformer());
		$this->assertNull($arguments['title']->getTransformer());

		$this->assertTrue(isset($arguments['subEntity']));
        $this->assertFalse($arguments['subEntity']->isKey());
        $this->assertFalse($arguments['subEntity']->isUnique());
        $this->assertFalse($arguments['subEntity']->hasDefault());
        $this->assertNull($arguments['subEntity']->getDefault());
        $this->assertFalse($arguments['subEntity']->hasType());
        $this->assertNull($arguments['subEntity']->getType());
		$this->assertEquals('subEntity', $arguments['subEntity']->getArgumentMetaData()->getName());
		$this->assertEquals(3, $arguments['subEntity']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['subEntity']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['subEntity']->getArgumentMetaData()->isOptional());
		$this->assertTrue($arguments['subEntity']->getArgumentMetaData()->hasClassMetaData());
		$this->validateSimpleEntity($arguments['subEntity']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['subEntity']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['subEntity']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getSubEntity()', $arguments['subEntity']->getMethodName());
		$this->assertEquals('sub_entity', $arguments['subEntity']->getKeyname());
		$this->assertFalse($arguments['subEntity']->hasHumanMethodName());
		$this->assertNull($arguments['subEntity']->getHumanMethodName());
		$this->assertFalse($arguments['subEntity']->hasTransformer());
		$this->assertNull($arguments['subEntity']->getTransformer());

		$this->assertTrue(isset($arguments['bigProperty']));
        $this->assertFalse($arguments['bigProperty']->isKey());
        $this->assertFalse($arguments['bigProperty']->isUnique());
        $this->assertFalse($arguments['bigProperty']->hasDefault());
        $this->assertNull($arguments['bigProperty']->getDefault());
        $this->assertFalse($arguments['bigProperty']->hasType());
        $this->assertNull($arguments['bigProperty']->getType());
		$this->assertEquals('bigProperty', $arguments['bigProperty']->getArgumentMetaData()->getName());
		$this->assertEquals(4, $arguments['bigProperty']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['bigProperty']->getArgumentMetaData()->isRecursive());
		$this->assertFalse($arguments['bigProperty']->getArgumentMetaData()->isOptional());
		$this->assertTrue($arguments['bigProperty']->getArgumentMetaData()->hasClassMetaData());
		$this->validateBigProperty($arguments['bigProperty']->getArgumentMetaData()->getClassMetaData());
		$this->assertFalse($arguments['bigProperty']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertNull($arguments['bigProperty']->getArgumentMetaData()->getArrayMetaData());
		$this->assertEquals('getBigProperty()', $arguments['bigProperty']->getMethodName());
		$this->assertEquals('big_property', $arguments['bigProperty']->getKeyname());
		$this->assertFalse($arguments['bigProperty']->hasHumanMethodName());
		$this->assertNull($arguments['bigProperty']->getHumanMethodName());
		$this->assertFalse($arguments['bigProperty']->hasTransformer());
		$this->assertNull($arguments['bigProperty']->getTransformer());

		$this->assertTrue(isset($arguments['simpleEntities']));
        $this->assertFalse($arguments['simpleEntities']->isKey());
        $this->assertFalse($arguments['simpleEntities']->isUnique());
        $this->assertFalse($arguments['simpleEntities']->hasDefault());
        $this->assertNull($arguments['simpleEntities']->getDefault());
        $this->assertFalse($arguments['simpleEntities']->hasType());
        $this->assertNull($arguments['simpleEntities']->getType());
		$this->assertEquals('simpleEntities', $arguments['simpleEntities']->getArgumentMetaData()->getName());
		$this->assertEquals(5, $arguments['simpleEntities']->getArgumentMetaData()->getPosition());
		$this->assertFalse($arguments['simpleEntities']->getArgumentMetaData()->isRecursive());
		$this->assertTrue($arguments['simpleEntities']->getArgumentMetaData()->isOptional());
		$this->assertFalse($arguments['simpleEntities']->getArgumentMetaData()->hasClassMetaData());
		$this->assertNull($arguments['simpleEntities']->getArgumentMetaData()->getClassMetaData());
		$this->assertTrue($arguments['simpleEntities']->getArgumentMetaData()->hasArrayMetaData());
		$this->assertTrue($arguments['simpleEntities']->getArgumentMetaData()->getArrayMetaData()->hasElementsType());
		$this->assertEquals('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface', $arguments['simpleEntities']->getArgumentMetaData()->getArrayMetaData()->getElementsType());
		$this->assertEquals('getSimpleEntities()', $arguments['simpleEntities']->getMethodName());
		$this->assertEquals('simple_entities', $arguments['simpleEntities']->getKeyname());
		$this->assertFalse($arguments['simpleEntities']->hasHumanMethodName());
		$this->assertNull($arguments['simpleEntities']->getHumanMethodName());
		$this->assertFalse($arguments['simpleEntities']->hasTransformer());
		$this->assertNull($arguments['simpleEntities']->getTransformer());
	}

}
