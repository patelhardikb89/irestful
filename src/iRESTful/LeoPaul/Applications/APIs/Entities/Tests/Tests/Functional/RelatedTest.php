<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Functional\Entities;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;

final class RelatedTest extends \PHPUnit_Framework_TestCase {
    private $complexEntityUuid;
    private $entityRepository;
    private $entityRelationRepository;
    private $entityService;
    private $firstEntity;
    private $secondEntity;
    public function setUp() {

        \iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Installations\Database::install();

        $this->complexEntityUuid = 'f9f63b88-889c-43b1-9cef-8acb26b910a7';

        $firstData = [
            'container' => 'complex_entity',
            'data' => [
                'uuid' => $this->complexEntityUuid,
                'slug' => 'this-is-a-complex-slug',
                'name' => 'ComplexEntity first title',
                'description' => 'Complex entity first description.  Oh yeah!',
                'simple_entity' => [
                    'uuid' => '65d42fab-bd6d-4048-ae70-0cff51defa15',
                    'slug' => 'this-is-a-simple-slug',
                    'title' => 'This is the first title',
                    'description' => 'This is just the first description.  Hurray!',
                    'created_on' => time() - 20

                ],
                'simple_entities' => [
                    [
                        'uuid' => 'a9672885-6038-439c-857e-b018768f1ecd',
                        'slug' => 'sub-simple-entity-slug',
                        'title' => 'First sub simple entity.',
                        'description' => 'First sub simple entity description.',
                        'created_on' => time() - 30
                    ],
                    [
                        'uuid' => 'aa21f472-dcb1-474e-9535-9fa11ca5e257',
                        'slug' => 'sub-simple-entity-slug-second',
                        'title' => 'Second sub simple entity.',
                        'description' => 'Second sub simple entity description.',
                        'created_on' => time() - 30
                    ]
                ],
                'created_on' => time() - 20
            ]
        ];

        $updatedData = [
            'container' => 'complex_entity',
            'data' => [
                'uuid' => $this->complexEntityUuid,
                'slug' => 'updated-this-is-an-updated-first-slug',
                'name' => 'Updated - This is an updated first title.',
                'description' => 'Updated - This is an updated first description!',
                'simple_entity' => [
                    'uuid' => '65d42fab-bd6d-4048-ae70-0cff51defa15',
                    'slug' => 'updated-this-is-a-simple-slug',
                    'title' => 'Updated - This is the first title',
                    'description' => 'Updated - This is just the first description.  Hurray!',
                    'created_on' => time() - 20
                ],
                'simple_entities' => [
                    [
                        'uuid' => 'a9672885-6038-439c-857e-b018768f1ecd',
                        'slug' => 'updated-sub-simple-entity-slug',
                        'title' => 'Updated first sub simple entity.',
                        'description' => 'Updated first sub simple entity description.',
                        'created_on' => time() - 30
                    ]
                ],
                'created_on' => time() - 30
            ]

        ];

        $params = $params = [
            'transformer_objects' => [
                'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter(),
                'iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter('America/Montreal')
            ],
            'container_class_mapper' => [
                'simple_entity' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity',
                'complex_entity' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ComplexEntity'
            ],
            'interface_class_mapper' => [
                'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity',
                'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ComplexEntityInterface' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ComplexEntity'
            ],
            'delimiter' => '___',
            'base_url' => getenv('API_PROTOCOL').'://'.getenv('ENTITIES_API_URL'),
            'port' => getenv('API_PORT')
        ];

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $this->entityRepository = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory($params)->create();

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $this->entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory($params)->create();

        $entityServiceFactoryAdapter = new HttpEntityServiceFactoryAdapter();
        $this->entityService = $entityServiceFactoryAdapter->fromDataToEntityServiceFactory($params)->create();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory($params)->create();
        $entityAdapter = $entityAdapterAdapter->fromRepositoriesToEntityAdapter($this->entityRepository, $this->entityRelationRepository);

        $this->firstEntity = $entityAdapter->fromDataToEntity($firstData);
        $this->updatedEntity = $entityAdapter->fromDataToEntity($updatedData);

    }

    public function tearDown() {
        
        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();
    }

    public function testInsertComplexEntity_thenRetrieveRelatedSimpleEntities_thenUpdate_thenRetrieveRelatedSimpleEntities_Success() {

        //first entity:
        $this->entityService->insert($this->firstEntity);
        $simpleEntities = $this->entityRelationRepository->retrieve([
            'master_container' => 'complex_entity',
            'slave_container' => 'simple_entity',
            'slave_property' => 'simple_entities',
            'master_uuid' => $this->complexEntityUuid
        ]);
        $this->assertEquals($this->firstEntity->getSimpleEntities(), $simpleEntities);

        //updated entity:
        $this->entityService->update($this->firstEntity, $this->updatedEntity);
        $simpleEntities = $this->entityRelationRepository->retrieve([
            'master_container' => 'complex_entity',
            'slave_container' => 'simple_entity',
            'slave_property' => 'simple_entities',
            'master_uuid' => $this->complexEntityUuid
        ]);
        $this->assertEquals($this->updatedEntity->getSimpleEntities(), $simpleEntities);
    }

}
