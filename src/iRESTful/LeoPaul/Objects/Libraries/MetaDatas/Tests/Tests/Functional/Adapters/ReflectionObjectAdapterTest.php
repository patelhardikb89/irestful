<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Functional\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteObjectMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\BigProperty;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntity;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapter;

final class ReflectionObjectAdapterTest extends \PHPUnit_Framework_TestCase {
	private $simpleEntityUuid;
	private $simpleEntity;
    private $simpleEntityWithDomainNames;
    private $simpleEntityWithInvalidDomainNames;
	private $simpleEntityData;
	private $simpleEntityDataNonHumanReadable;
    private $simpleEntityDataWithDomainNames;
    private $simpleEntityDataWithInvalidDomainNames;
    private $subcomplexEntity;
    private $firstSubBigProperty;
    private $bigProperty;
	private $complexEntity;
	private $complexEntityData;
	private $complexEntityWithSimpleEntities;
    private $complexEntityWithoutSimpleEntities;
	private $complexEntityDataWithSimpleEntities;
	private $complexEntityDataNonHumanReadableWithSimpleEntities;
	private $complexEntityDataWithSimpleEntityUuids;
    private $complexEntityDataWithNullSimpleEntities;
    private $complexEntityDataWithEmptySimpleEntities;
    private $complexEntityDataWithoutSimpleEntities;
    private $complexEntityDataWithSubEntityUuid;
	private $adapter;
	public function setUp() {

		$delimiter = '___';

		$transformerObjects = [
			'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new ConcreteUuidAdapter(),
			'iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new ConcreteDateTimeAdapter('America/Montreal'),
            'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface' => new DomainNameAdapter()
		];

		$containerClassMapper = [
			'complex_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntity',
			'simple_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

		$interfaceClassMapper = [
			'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

		$factory = new ReflectionObjectAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);
		$this->adapter = $factory->create();

		//setup the simple entity data:
        $float = (float) 100/1000;
		$this->simpleEntityUuid = '1aa6527e-dde0-4d44-8725-0f3917d89682';
		$this->simpleEntityData = [
			'uuid' => $this->simpleEntityUuid,
            'slug' => 'this-is-a-slug',
            'title' => 'This is the first title',
            'domain_names' => null,
            'float' => $float,
            'created_on' => time() - 20
		];

        $this->simpleEntityDataWithDomainNames = [
            'uuid' => $this->simpleEntityUuid,
            'slug' => 'this-is-a-slug',
            'title' => 'This is the first title',
            'domain_names' => 'irestful.com;google.com',
            'float' => null,
            'created_on' => time() - 20
        ];

        $this->simpleEntityDataWithInvalidDomainNames = [
            'uuid' => $this->simpleEntityUuid,
            'slug' => 'this-is-a-slug',
            'title' => 'This is the first title',
            'domain_names' => new \DateTime(),
            'float' => null,
            'created_on' => time() - 20
        ];

		$this->simpleEntityDataNonHumanReadable = [
			'uuid' => hex2bin(str_replace('-', '', $this->simpleEntityData['uuid'])),
            'title' => $this->simpleEntityData['title'],
            'slug' => $this->simpleEntityData['slug'],
            'domain_names' => null,
            'float' => $float,
            'created_on' => $this->simpleEntityData['created_on']
		];

		$createdOn = new \DateTime();
		$createdOn->setTimestamp($this->simpleEntityData['created_on']);

		$uuid = new ConcreteUuid($this->simpleEntityData['uuid']);
		$this->simpleEntity = new SimpleEntity($uuid, $createdOn, $this->simpleEntityData['title'], $this->simpleEntityData['slug'], null, $this->simpleEntityData['float']);
        $this->simpleEntityWithDomainNames = new SimpleEntity($uuid, $createdOn, $this->simpleEntityData['title'], $this->simpleEntityData['slug'], ['irestful.com', 'google.com']);
        $this->simpleEntityWithInvalidDomainNames = new SimpleEntity($uuid, $createdOn, $this->simpleEntityData['title'], $this->simpleEntityData['slug'], [new \DateTime(), new \DateTime()]);

		//setup the complex entity data:
		$this->complexEntityData = [
			'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
            'title' => 'This is some title',
            'sub_entity' => $this->simpleEntityData,
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
			'simple_entities' => null,
			'sub_complex_entity' => [
				'uuid' => '5f35159b-9c13-421a-afc2-9b116b6cb731',
	            'title' => 'This is some sub title',
	            'sub_entity' => $this->simpleEntityData,
	            'big_property___title' => '-> Some big sub property title',
                'big_property___is_good' => false,
				'simple_entities' => null,
				'sub_complex_entity' => null,
                'empty_big_property' => null,
	            'created_on' => time()
			],
            'empty_big_property' => null,
            'created_on' => time()
		];

		$subCreatedOn = new \DateTime();
		$subCreatedOn->setTimestamp($this->complexEntityData['sub_complex_entity']['created_on']);

		$subUuid = new ConcreteUuid($this->complexEntityData['sub_complex_entity']['uuid']);
		$this->firstSubBigProperty = new BigProperty($this->complexEntityData['sub_complex_entity']['big_property___title']);
		$this->subcomplexEntity = new ComplexEntity($subUuid, $subCreatedOn, $this->complexEntityData['sub_complex_entity']['title'], $this->simpleEntity, $this->firstSubBigProperty);

		$createdOn = new \DateTime();
		$createdOn->setTimestamp($this->complexEntityData['created_on']);

		$uuid = new ConcreteUuid($this->complexEntityData['uuid']);
		$this->bigProperty = new BigProperty($this->complexEntityData['big_property___title']);
		$this->complexEntity = new ComplexEntity($uuid, $createdOn, $this->complexEntityData['title'], $this->simpleEntity, $this->bigProperty, null, $this->subcomplexEntity);

		//setup the complex entity data with a sub simple entity:
		$this->complexEntityDataWithSimpleEntities = [
			'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
            'title' => 'This is some title',
            'sub_entity' => $this->simpleEntityData,
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
			'simple_entities' => [
				$this->simpleEntityData
			],
			'sub_complex_entity' => null,
            'empty_big_property' => null,
            'created_on' => time()
		];

		$this->complexEntityDataNonHumanReadableWithSimpleEntities = [
			'uuid' => hex2bin(str_replace('-', '', $this->complexEntityDataWithSimpleEntities['uuid'])),
            'title' => $this->complexEntityDataWithSimpleEntities['title'],
            'sub_entity' => $this->simpleEntityDataNonHumanReadable,
            'big_property___title' => $this->complexEntityDataWithSimpleEntities['big_property___title'],
            'big_property___is_good' => false,
			'simple_entities' => [
				$this->simpleEntityDataNonHumanReadable
			],
			'sub_complex_entity' => $this->complexEntityDataWithSimpleEntities['sub_complex_entity'],
            'empty_big_property' => null,
            'created_on' => $this->complexEntityDataWithSimpleEntities['created_on'],
		];

		$this->complexEntityWithSimpleEntities = new ComplexEntity($uuid, $createdOn, $this->complexEntityData['title'], $this->simpleEntity, $this->bigProperty, [$this->simpleEntity]);
        $this->complexEntityWithoutSimpleEntities = new ComplexEntity($uuid, $createdOn, $this->complexEntityData['title'], $this->simpleEntity, $this->bigProperty);

        //setup complex entity data with simple entity uuid:
		$this->complexEntityDataWithSimpleEntityUuids = [
			'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
            'title' => 'This is some title',
            'sub_entity' => $this->simpleEntityData,
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
			'simple_entities' => [
				$this->simpleEntityUuid
			],
			'sub_complex_entity' => null,
            'empty_big_property' => null,
            'created_on' => time()
		];

        $this->complexEntityDataWithNullSimpleEntities = [
            'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
            'title' => 'This is some title',
            'sub_entity' => $this->simpleEntityData,
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
			'simple_entities' => null,
			'sub_complex_entity' => null,
            'empty_big_property' => null,
            'created_on' => time()
        ];

        $this->complexEntityDataWithEmptySimpleEntities = [
            'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
            'title' => 'This is some title',
            'sub_entity' => $this->simpleEntityData,
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
			'simple_entities' => [],
			'sub_complex_entity' => null,
            'empty_big_property' => null,
            'created_on' => time()
        ];

        $this->complexEntityDataWithoutSimpleEntities = [
            'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
            'title' => 'This is some title',
            'sub_entity' => $this->simpleEntityData,
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
			'sub_complex_entity' => null,
            'empty_big_property' => null,
            'created_on' => time()
        ];

        $this->complexEntityDataWithSubEntityUuid = [
			'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
			'simple_entities' => [
				$this->simpleEntityUuid
			],
			'sub_complex_entity' => '',
            'empty_big_property' => '',
            'big_property___title' => 'Some big sub property title',
            'big_property___is_good' => false,
            'sub_entity' => $this->simpleEntityUuid,
            'title' => 'This is some title',
            'created_on' => time()
		];

	}

	public function tearDown() {

	}

    public function testFromObjectToSubObjects_Success() {

        $subObjects = $this->adapter->fromObjectToSubObjects($this->complexEntityWithSimpleEntities);

        $this->assertEquals([$this->simpleEntity, $this->bigProperty, $this->simpleEntity], $subObjects);
    }

    public function testFromObjectToSubObjects_withSubComplexEntity_Success() {

        $subObjects = $this->adapter->fromObjectToSubObjects($this->complexEntity);

        $this->assertEquals([$this->simpleEntity, $this->bigProperty, $this->simpleEntity, $this->firstSubBigProperty, $this->subcomplexEntity], $subObjects);

    }

    public function testFromObjectToSubObjects_withInvalidObject_throwsObjectException() {

        $asserted = false;
        try {

            $this->adapter->fromObjectToSubObjects('not an object');

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromObjectsToSubObjects_Success() {

        $subObjects = $this->adapter->fromObjectsToSubObjects([$this->complexEntityWithSimpleEntities, $this->complexEntity]);

        $this->assertEquals([$this->simpleEntity, $this->bigProperty, $this->simpleEntity, $this->simpleEntity, $this->bigProperty, $this->simpleEntity, $this->firstSubBigProperty, $this->subcomplexEntity], $subObjects);

    }

    public function testFromObjectsToSubObjects_withOneInvalidObject_Success() {

        $subObjects = $this->adapter->fromObjectsToSubObjects([$this->complexEntityWithSimpleEntities, $this->complexEntity, 'invalid object']);

        $this->assertEquals([$this->simpleEntity, $this->bigProperty, $this->simpleEntity, $this->simpleEntity, $this->bigProperty, $this->simpleEntity, $this->firstSubBigProperty, $this->subcomplexEntity], $subObjects);
    }

    public function testFromObjectToData_withSimpleEntityWithDomainNames_Success() {

        $data = $this->adapter->fromObjectToData($this->simpleEntityWithDomainNames, true);

		$this->assertEquals($this->simpleEntityDataWithDomainNames, $data);

	}

    public function testFromObjectToData_withSimpleEntityWithDomainNames_withInvalidDomainNames_throwsObjectException() {

        $asserted = false;
        try {

            $this->adapter->fromObjectToData($this->simpleEntityWithInvalidDomainNames, true);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

	}

	public function testFromObjectToData_withSimpleEntity_Success() {

		$data = $this->adapter->fromObjectToData($this->simpleEntity, true);

		$this->assertEquals($this->simpleEntityData, $data);

	}

	public function testFromDataToObject_withSimpleEntity_withContainer_Success() {

		$simpleEntity = $this->adapter->fromDataToObject([
			'container' => 'simple_entity',
			'data' => $this->simpleEntityData
		]);

		$this->assertEquals($this->simpleEntity, $simpleEntity);

	}

    public function testFromDataToObject_withSimpleEntityWithDomainNames_withContainer_Success() {

		$simpleEntity = $this->adapter->fromDataToObject([
			'container' => 'simple_entity',
			'data' => $this->simpleEntityDataWithDomainNames
		]);

		$this->assertEquals($this->simpleEntityWithDomainNames, $simpleEntity);

	}

    public function testFromDataToObject_withSimpleEntityWithDomainNames_withContainer_withInvalidDomainNames_throwsObjectException() {

        $asserted = false;
        try {

            $this->adapter->fromDataToObject([
    			'container' => 'simple_entity',
    			'data' => $this->simpleEntityDataWithInvalidDomainNames
    		]);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

	}

	public function testFromDataToObject_withSimpleEntity_withoutName_withoutContainer_throwsObjectException() {

		$asserted = false;
		try {

			$this->adapter->fromDataToObject([
				'data' => $this->simpleEntityData
			]);

		} catch (ObjectException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToObject_withSimpleEntity_withContainer_withoutData_throwsObjectException() {

		$asserted = false;
		try {

			$this->adapter->fromDataToObject([
				'container' => 'simple_entity'
			]);

		} catch (ObjectException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToObject_withSimpleEntity_withContainer_withClassName_throwsObjectException() {

		$asserted = false;
		try {

			$this->adapter->fromDataToObject([
				'class' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Functional\Adapters\ReflectionObjectAdapterTest',
				'container' => 'simple_entity',
				'data' => $this->simpleEntityData
			]);

		} catch (ObjectException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToObject_withSimpleEntity_withInvalidContainer_throwsObjectException() {

		$asserted = false;
		try {

			$this->adapter->fromDataToObject([
				'container' => 'invalid_container',
				'data' => $this->simpleEntityData
			]);

		} catch (ObjectException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromObjectMetaDataToData_withComplexEntity_Success() {

		$data = $this->adapter->fromObjectToData($this->complexEntity, true);

		$this->assertEquals($this->complexEntityData, $data);

	}

	public function testFromObjectMetaDataToData_withObjectOfClassWithoutAnnotations_throwsClassMetaDataException_throwsObjectException() {

		$asserted = false;
		try {

			$this->adapter->fromObjectToData(new \DateTime(), true);

		} catch (ObjectException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToObject_withComplexEntity_withContainer_Success() {

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityData
		]);

		$this->assertEquals($this->complexEntity, $complexEntity);

	}

	public function testFromDataToObject_withComplexEntity_withSubSimpleEntity_withContainer_Success() {

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithSimpleEntities
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);

	}

	public function testFromObjectMetaDataToData_withComplexEntity_withSubSimpleEntity_isHumanReadable_Success() {

		$data = $this->adapter->fromObjectToData($this->complexEntityWithSimpleEntities, true);

		$this->assertEquals($this->complexEntityDataWithSimpleEntities, $data);

	}

	public function testFromDataToObjects_withTwoComplexEntity_withOneSimpleEntity_withSubSimpleEntity_withContainer_Success() {

		$objects = $this->adapter->fromDataToObjects([
			[
				'container' => 'complex_entity',
				'data' => $this->complexEntityData
			],
			[
				'container' => 'complex_entity',
				'data' => $this->complexEntityDataWithSimpleEntities
			],
			[
				'container' => 'simple_entity',
				'data' => $this->simpleEntityData
			]
		], true);

		$this->assertEquals($objects[0], $this->complexEntity);
		$this->assertEquals($objects[1], $this->complexEntityWithSimpleEntities);
		$this->assertEquals($objects[2], $this->simpleEntity);

	}

	public function testFromObjectMetaDataToData_withComplexEntity_withSubSimpleEntity_Success() {

		$data = $this->adapter->fromObjectToData($this->complexEntityWithSimpleEntities, false);

		$this->assertEquals($this->complexEntityDataNonHumanReadableWithSimpleEntities, $data);

	}

	public function testFromDataToObject_withComplexEntityDataNonHumanReadableWithSimpleEntities_withSubSimpleEntity_withContainer_Success() {

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataNonHumanReadableWithSimpleEntities
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);

	}

    public function testFromDataToObject_withComplexEntity_withSubSimpleEntities_withContainer_withCallbackOnFail_Success() {

		$hasBeenCalled = false;
		$rightData = $this->simpleEntityData;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled, $rightData) {

            $className = $data['class'];
            $input = $data['input'];

			if ($className != 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity') {
				throw new \Exception('The className should have been iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity.  The provided className was: '.$className);
			}

			if ($rightData['uuid'] != $input) {
				throw new \Exception('The input was supposed to be the SimpleEntity uuid ('.$rightData['uuid'].').  This was provided: '.$input);
			}

			$hasBeenCalled = true;
			return $rightData;

		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithSimpleEntityUuids,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);
		$this->assertTrue($hasBeenCalled);

	}

    public function testFromDataToObject_withComplexEntity_withNullSubSimpleEntities_withContainer_withCallbackOnFail_Success() {

		$hasBeenCalled = false;
		$rightData = $this->simpleEntityData;
        $rightObject = $this->simpleEntity;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled, $rightData, $rightObject) {


            if (isset($data['master_container']) && isset($data['slave_type']) && isset($data['slave_property']) && isset($data['master_uuid'])) {

                if ($data['master_container'] != 'complex_entity') {
    				throw new \Exception('The master_container must be: complex_entity.  The provided className was: '.$data['master_container']);
    			}

                if ($data['slave_type'] != 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface') {
    				throw new \Exception('The slave_type must be: iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface.  The provided className was: '.$data['slave_type']);
    			}

                if ($data['slave_property'] != 'simple_entities') {
    				throw new \Exception('The slave_property must be: simple_entities.  The provided className was: '.$data['slave_property']);
    			}

                if ($data['master_uuid'] != 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3') {
    				throw new \Exception('The master_uuid must be: a718560e-72ba-4eeb-9a7b-bbe41a32c2f3.  The provided className was: '.$data['master_uuid']);
    			}

                $hasBeenCalled = true;
                return [
                    $rightObject
                ];

            }

            throw new \Exception('invalid request');

		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithNullSimpleEntities,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);
		$this->assertTrue($hasBeenCalled);

	}

    public function testFromDataToObject_withComplexEntity_withNullSubSimpleEntities_withContainer_withCallbackOnFail_returnsEmptySimpleEntities_Success() {

		$hasBeenCalled = false;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled) {


            if (isset($data['master_container']) && isset($data['slave_type']) && isset($data['slave_property']) && isset($data['master_uuid'])) {

                if ($data['master_container'] != 'complex_entity') {
    				throw new \Exception('The master_container must be: complex_entity.  The provided className was: '.$data['master_container']);
    			}

                if ($data['slave_type'] != 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface') {
    				throw new \Exception('The slave_type must be: iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface.  The provided className was: '.$data['slave_type']);
    			}

                if ($data['slave_property'] != 'simple_entities') {
    				throw new \Exception('The slave_property must be: simple_entities.  The provided className was: '.$data['slave_property']);
    			}

                if ($data['master_uuid'] != 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3') {
    				throw new \Exception('The master_uuid must be: a718560e-72ba-4eeb-9a7b-bbe41a32c2f3.  The provided className was: '.$data['master_uuid']);
    			}

                $hasBeenCalled = true;
                return [];

            }

            throw new \Exception('invalid request');

		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithNullSimpleEntities,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithoutSimpleEntities, $complexEntity);
		$this->assertTrue($hasBeenCalled);

	}

    public function testFromDataToObject_withComplexEntity_withEmptySubSimpleEntities_withContainer_withCallbackOnFail_Success() {

		$hasBeenCalled = false;
		$rightData = $this->simpleEntityData;
        $rightObject = $this->simpleEntity;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled, $rightData, $rightObject) {


            if (isset($data['master_container']) && isset($data['slave_type']) && isset($data['slave_property']) && isset($data['master_uuid'])) {

                if ($data['master_container'] != 'complex_entity') {
    				throw new \Exception('The master_container must be: complex_entity.  The provided className was: '.$data['master_container']);
    			}

                if ($data['slave_type'] != 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface') {
    				throw new \Exception('The slave_type must be: iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface.  The provided className was: '.$data['slave_type']);
    			}

                if ($data['slave_property'] != 'simple_entities') {
    				throw new \Exception('The slave_property must be: simple_entities.  The provided className was: '.$data['slave_property']);
    			}

                if ($data['master_uuid'] != 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3') {
    				throw new \Exception('The master_uuid must be: a718560e-72ba-4eeb-9a7b-bbe41a32c2f3.  The provided className was: '.$data['master_uuid']);
    			}

                $hasBeenCalled = true;
                return [
                    $rightObject
                ];

            }

            throw new \Exception('invalid request');

		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithEmptySimpleEntities,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);
		$this->assertTrue($hasBeenCalled);

	}

    public function testFromDataToObject_withComplexEntity_withoutSubSimpleEntities_withContainer_withCallbackOnFail_Success() {

		$hasBeenCalled = false;
		$rightData = $this->simpleEntityData;
        $rightObject = $this->simpleEntity;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled, $rightData, $rightObject) {


            if (isset($data['master_container']) && isset($data['slave_type']) && isset($data['slave_property']) && isset($data['master_uuid'])) {

                if ($data['master_container'] != 'complex_entity') {
    				throw new \Exception('The master_container must be: complex_entity.  The provided className was: '.$data['master_container']);
    			}

                if ($data['slave_type'] != 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface') {
    				throw new \Exception('The slave_type must be: iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface.  The provided className was: '.$data['slave_type']);
    			}

                if ($data['slave_property'] != 'simple_entities') {
    				throw new \Exception('The slave_property must be: simple_entities.  The provided className was: '.$data['slave_property']);
    			}

                if ($data['master_uuid'] != 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3') {
    				throw new \Exception('The master_uuid must be: a718560e-72ba-4eeb-9a7b-bbe41a32c2f3.  The provided className was: '.$data['master_uuid']);
    			}

                $hasBeenCalled = true;
                return [
                    $rightObject
                ];

            }

            throw new \Exception('invalid request');

		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithoutSimpleEntities,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);
		$this->assertTrue($hasBeenCalled);

	}

    public function testFromDataToObject_withComplexEntity_withSubSimpleEntity_withContainer_withCallbackOnFail_returnsObject_Success() {

		$hasBeenCalled = false;
		$rightData = $this->simpleEntityData;
        $rightObject = $this->simpleEntity;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled, $rightData, $rightObject) {

            $className = $data['class'];
            $input = $data['input'];

			if ($className != 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity') {
				throw new \Exception('The className should have been iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity.  The provided className was: '.$className);
			}

			if ($rightData['uuid'] != $input) {
				throw new \Exception('The input was supposed to be the SimpleEntity uuid ('.$rightData['uuid'].').  This was provided: '.$input);
			}

			$hasBeenCalled = true;
			return $rightObject;

		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataWithSubEntityUuid,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);
		$this->assertTrue($hasBeenCalled);

	}

	public function testFromDataToObject_withComplexEntity_withSubSimpleEntity_withContainer_callOnFailShouldNotBeBalled_Success() {

		$hasBeenCalled = false;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled) {
			$hasBeenCalled = true;
		};

		$complexEntity = $this->adapter->fromDataToObject([
			'container' => 'complex_entity',
			'data' => $this->complexEntityDataNonHumanReadableWithSimpleEntities,
			'callback_on_fail' => $callBackOnFail
		]);

		$this->assertEquals($this->complexEntityWithSimpleEntities, $complexEntity);
		$this->assertFalse($hasBeenCalled);

	}

	public function testFromDataToObject_withInvalidDataForClassName_throwsExceptionInCallbackFn_throwsObjectException() {

		$hasBeenCalled = false;
		$callBackOnFail = function(array $data) use(&$hasBeenCalled) {

            $className = $data['class'];
            $input = $data['input'];

			if (!isset($input['uuid']) || !isset($input['title'])) {
				throw new \Exception('The uuid and title keyname should have been provided in the input.');
			}

			if ($input['uuid'] != 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3') {
				throw new \Exception('The uuid should be: a718560e-72ba-4eeb-9a7b-bbe41a32c2f3');
			}

			if ($input['title'] != 'This is some title') {
				throw new \Exception('The title should be: This is some title');
			}

			$hasBeenCalled = true;
			throw new \Exception('Everything is ok for test!');
		};

        $asserted = false;
		try {

			$complexEntity = $this->adapter->fromDataToObject([
				'container' => 'complex_entity',
				'data' => [
					'uuid' => 'a718560e-72ba-4eeb-9a7b-bbe41a32c2f3',
		            'title' => 'This is some title'
				],
				'callback_on_fail' => $callBackOnFail
			]);

		} catch (ObjectException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
		$this->assertTrue($hasBeenCalled);

	}

	public function testFromDataToObjects_withTwoComplexEntity_withOneComplexEntityDataNonHumanReadableWithSimpleEntities_withOneSimpleEntity_withSubSimpleEntity_withContainer_Success() {

		$objects = $this->adapter->fromDataToObjects([
			[
				'container' => 'complex_entity',
				'data' => $this->complexEntityData
			],
			[
				'container' => 'complex_entity',
				'data' => $this->complexEntityDataNonHumanReadableWithSimpleEntities
			],
			[
				'container' => 'simple_entity',
				'data' => $this->simpleEntityDataNonHumanReadable
			]
		]);

		$this->assertEquals($objects[0], $this->complexEntity);
		$this->assertEquals($objects[1], $this->complexEntityWithSimpleEntities);
		$this->assertEquals($objects[2], $this->simpleEntity);

	}

    public function testFromObjectToRelationObjects_Success() {

        $relationObjects = $this->adapter->fromObjectToRelationObjects($this->complexEntityWithSimpleEntities);

        $this->assertEquals(['simple_entities' => [$this->simpleEntity]], $relationObjects);

    }

    public function testFromObjectToRelationObjects_withInvalidObject_throwsClassMetaDataException_throwsObjectException() {

        $asserted = false;
        try {

            $this->adapter->fromObjectToRelationObjects('not an object');

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromObjectsToRelationObjectsList_Success() {

        $relationObjects = $this->adapter->fromObjectsToRelationObjectsList([$this->complexEntity, $this->complexEntityWithSimpleEntities, $this->simpleEntity]);

        $this->assertEquals([[], ['simple_entities' => [$this->simpleEntity]], []], $relationObjects);

    }
}
