<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Functional;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;
use iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityPartialSetRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntitySetRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;

final class ListsTests extends \PHPUnit_Framework_TestCase {
    private $firstUuid;
    private $updatedFirstUuid;
    private $secondUuid;
    private $firstSlug;
    private $updatedFirstSug;
    private $secondSlug;
    private $firstSimpleEntity;
    private $secondSimpleEntity;
    private $updatedFirstSimpleEntity;
    private $firstData;
    private $updatedFirstData;
    private $secondData;
    private $oneEntityPartialSet;
    private $twoEntityPartialSet;
    private $httpRequestAdapter;
    private $curlApplication;
    private $entityRetrieverCriteriaAdapter;
    private $entitySetRetrieverCriteriaAdapter;
    private $entityRepository;
    private $entityRelationRepository;
    private $entityPartialSetRepository;
    private $entitySetRepository;
    private $entityService;
    private $crudHelper;
    public function setUp() {
        
        \iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Installations\Database::install();

        $this->firstUuid = '65d42fab-bd6d-4048-ae70-0cff51defa15';
        $this->firstSlug = 'this-is-a-simple-slug';
        $this->firstData = [
            'uuid' => $this->firstUuid,
            'slug' => $this->firstSlug,
            'title' => 'This is the first title',
            'description' => 'This is just the first description.  Hurray!',
            'created_on' => time() - 20
        ];

        $this->updatedFirstSug = 'this-is-an-updated-first-slug';
        $this->updatedFirstData = [
            'uuid' => $this->firstUuid,
            'slug' => $this->updatedFirstSug,
            'title' => 'This is an updated first title.',
            'description' => 'This is an updated first description!',
            'created_on' => time() - 30
        ];

        $this->secondUuid = '1a867c63-324f-4539-b485-fc7f152e7175';
        $this->secondSlug = 'this-is-a-second-slug';
        $this->secondData = [
            'uuid' => $this->secondUuid,
            'slug' => $this->secondSlug,
            'title' => 'This is the second title',
            'description' => 'This is just the second description.  Yup.',
            'created_on' => time()
        ];

        $params = [
            'transformer_objects' => [
                'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter(),
                'iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter('America/Montreal')
            ],
            'container_class_mapper' => [
                'simple_entity' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity'
            ],
            'interface_class_mapper' => [
                'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity'
            ],
            'delimiter' => '___',
            'base_url' => getenv('API_PROTOCOL').'://'.getenv('ENTITIES_API_URL'),
            'port' => getenv('API_PORT')
        ];

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $this->entityRepository = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory($params)->create();

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $this->entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory($params)->create();

        $entityPartialSetRepositoryFactoryAdapter = new HttpEntityPartialSetRepositoryFactoryAdapter();
        $this->entityPartialSetRepository = $entityPartialSetRepositoryFactoryAdapter->fromDataToEntityPartialSetRepositoryFactory($params)->create();

        $entitySetRepositoryFactoryAdapter = new HttpEntitySetRepositoryFactoryAdapter();
        $this->entitySetRepository = $entitySetRepositoryFactoryAdapter->fromDataToEntitySetRepositoryFactory($params)->create();

        $entityServiceFactoryAdapter = new HttpEntityServiceFactoryAdapter();
        $this->entityService = $entityServiceFactoryAdapter->fromDataToEntityServiceFactory($params)->create();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory($params)->create();
        $entityAdapter = $entityAdapterAdapter->fromRepositoriesToEntityAdapter($this->entityRepository, $this->entityRelationRepository);

        $entityPartialSetAdapterFactoryAdapter = new HttpEntityPartialSetAdapterFactoryAdapter();
        $entityPartialSetAdapter = $entityPartialSetAdapterFactoryAdapter->fromDataToEntityPartialSetAdapterFactory($params)->create();

        $this->firstSimpleEntity = $entityAdapter->fromDataToEntity([
            'container' => 'simple_entity',
            'data' => $this->firstData
        ]);

        $this->secondSimpleEntity = $entityAdapter->fromDataToEntity([
            'container' => 'simple_entity',
            'data' => $this->secondData
        ]);

        $this->updatedFirstSimpleEntity = $entityAdapter->fromDataToEntity([
            'container' => 'simple_entity',
            'data' => $this->updatedFirstData
        ]);

        $this->oneEntityPartialSet = $entityPartialSetAdapter->fromDataToEntityPartialSet([
            'index' => 0,
            'amount' => 1,
            'total_amount' => 1,
            'entities' => [
                [
                    'container' => 'simple_entity',
                    'data' => $this->firstData
                ]
            ]
        ]);

        $this->twoEntityPartialSet = $entityPartialSetAdapter->fromDataToEntityPartialSet([
            'index' => 0,
            'amount' => 2,
            'total_amount' => 2,
            'entities' => [
                [
                    'container' => 'simple_entity',
                    'data' => $this->secondData
                ],
                [
                    'container' => 'simple_entity',
                    'data' => $this->firstData
                ]
            ]
        ]);
    }

    public function tearDown() {
        
        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();
    }

    private function readPartialSet($index, $amount) {
        return $this->entityPartialSetRepository->retrieve([
            'container' => 'simple_entity',
            'index' => $index,
            'amount' => $amount
        ]);
    }

    private function readSet(array $uuids) {
        return $this->entitySetRepository->retrieve([
            'container' => 'simple_entity',
            'uuids' => $uuids
        ]);
    }

    public function testInsert_thenReadPartialSet_thenInsert_thenReadPartialSet() {

        $this->entityService->insert($this->firstSimpleEntity);

        $simpleEntities = $this->readPartialSet(0, 100);
        $this->assertEquals($this->oneEntityPartialSet, $simpleEntities);

        $this->entityService->insert($this->secondSimpleEntity);

        $simpleEntities = $this->readPartialSet(0, 100);
        $this->assertEquals($this->twoEntityPartialSet, $simpleEntities);

        $this->entityService->delete($this->firstSimpleEntity);

        $this->entityService->delete($this->secondSimpleEntity);

    }

    public function testInsert_thenReadSet_thenInsert_thenReadSet() {

        $this->entityService->insert($this->firstSimpleEntity);

        $simpleEntities = $this->readSet([$this->firstUuid]);
        $this->assertEquals([$this->firstSimpleEntity], $simpleEntities);

        $this->entityService->insert($this->secondSimpleEntity);

        $simpleEntities = $this->readSet([$this->firstUuid, $this->secondUuid]);
        $this->assertEquals([$this->secondSimpleEntity, $this->firstSimpleEntity], $simpleEntities);

        $this->entityService->delete($this->firstSimpleEntity);

        $this->entityService->delete($this->secondSimpleEntity);

    }

}
