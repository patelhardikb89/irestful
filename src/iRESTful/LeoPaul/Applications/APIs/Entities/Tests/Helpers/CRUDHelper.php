<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Helpers;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntitySetServiceFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntitySetRepositoryFactoryAdapter;

final class CRUDHelper {
    private $phpunit;
    private $containerName;
    private $entityRepository;
    private $entitySetRepository;
    private $entityService;
    private $entitySetService;
    private $firstEntity;
    private $secondEntity;
    private $updatedEntity;
    private $keyname;
    private $keynames;
    public function __construct(
        \PHPUnit_Framework_TestCase $phpunit,
        array $configs,
        array $firstData,
        array $updatedData,
        array $keyname = null,
        array $keynames = null
    ) {

        $this->phpunit = $phpunit;
        $this->containerName = $firstData['container'];
        $this->keyname = $keyname;
        $this->keynames = $keynames;

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $this->entityRepository = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory($configs)->create();

        $entitySetRepositoryFactoryAdapter = new HttpEntitySetRepositoryFactoryAdapter();
        $this->entitySetRepository = $entitySetRepositoryFactoryAdapter->fromDataToEntitySetRepositoryFactory($configs)->create();

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory($configs)->create();

        $entityServiceFactoryAdapter = new HttpEntityServiceFactoryAdapter();
        $this->entityService = $entityServiceFactoryAdapter->fromDataToEntityServiceFactory($configs)->create();

        $entitySetServiceFactoryAdapter = new HttpEntitySetServiceFactoryAdapter();
        $this->entitySetService = $entitySetServiceFactoryAdapter->fromDataToEntitySetServiceFactory($configs)->create();

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory($configs)->create();
        $entityAdapter = $entityAdapterAdapter->fromRepositoriesToEntityAdapter($this->entityRepository, $entityRelationRepository);

        $this->firstEntity = $entityAdapter->fromDataToEntity($firstData);
        $this->updatedEntity = $entityAdapter->fromDataToEntity($updatedData);
    }

    public function execute() {

        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());
        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());

        $this->entityService->insert($this->firstEntity);

        $readEntity = $this->read($this->firstEntity->getUuid()->getHumanReadable());
        $this->phpunit->assertEquals($readEntity, $this->firstEntity);

        if (!empty($this->keyname)) {
            $entity = $this->readFromKeyname($this->keyname['name'], $this->keyname['value']);
            $this->phpunit->assertEquals($entity, $this->firstEntity);
        }

        if (!empty($this->keynames)) {
            $entity = $this->readFromKeynames($this->keynames);
            $this->phpunit->assertEquals($entity, $this->firstEntity);
        }

        $this->entityService->update($this->firstEntity, $this->updatedEntity);

        $readEntity = $this->read($this->updatedEntity->getUuid()->getHumanReadable());
        $this->phpunit->assertEquals($readEntity, $this->updatedEntity);

        $this->entityService->delete($this->updatedEntity);

        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());
        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());
    }

    public function executeSet() {

        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());
        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());

        $this->entitySetService->insert([$this->firstEntity]);

        $readEntities = $this->readSet([$this->firstEntity->getUuid()->getHumanReadable()]);
        $this->phpunit->assertEquals($readEntities, [$this->firstEntity]);

        $this->entitySetService->update([$this->firstEntity], [$this->updatedEntity]);

        $readEntities = $this->readSet([$this->updatedEntity->getUuid()->getHumanReadable()]);
        $this->phpunit->assertEquals($readEntities, [$this->updatedEntity]);

        $this->entitySetService->delete([$this->updatedEntity]);

        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());
        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());
    }

    private function readFails($uuid) {
        $output = $this->read($uuid);
        $this->phpunit->assertNull($output);
    }

    private function readSet(array $uuids) {
        return $this->entitySetRepository->retrieve([
            'container' => $this->containerName,
            'uuids' => $uuids
        ]);
    }

    private function read($uuid) {
        return $this->entityRepository->retrieve([
            'container' => $this->containerName,
            'uuid' => $uuid
        ]);
    }

    private function readFromKeyname($name, $value) {
        return $this->entityRepository->retrieve([
            'container' => $this->containerName,
            'keyname' => [
                'name' => $name,
                'value' => $value
            ]
        ]);
    }

    private function readFromKeynames(array $keynames) {

        $params = [
            'container' => $this->containerName,
            'keynames' => []
        ];

        foreach($keynames as $name => $value) {
            $params['keynames'][] = [
                'name' => $name,
                'value' => $value
            ];
        }

        return $this->entityRepository->retrieve($params);
    }

}
