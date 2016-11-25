<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Helpers;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntitySetServiceFactoryAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntitySetRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

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
        $this->compareObjects($readEntity, $this->firstEntity);

        if (!empty($this->keyname)) {
            $entity = $this->readFromKeyname($this->keyname['name'], $this->keyname['value']);
            $this->compareObjects($entity, $this->firstEntity);
        }

        if (!empty($this->keynames)) {
            $entity = $this->readFromKeynames($this->keynames);
            $this->compareObjects($entity, $this->firstEntity);
        }

        $this->entityService->update($this->firstEntity, $this->updatedEntity);

        $readEntity = $this->read($this->updatedEntity->getUuid()->getHumanReadable());
        $this->compareObjects($readEntity, $this->updatedEntity);

        $this->entityService->delete($this->updatedEntity);

        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());
        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());
    }

    public function executeSet() {

        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());
        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());

        $this->entitySetService->insert([$this->firstEntity]);

        $readEntities = $this->readSet([$this->firstEntity->getUuid()->getHumanReadable()]);
        $this->compareObjects($readEntities[0], $this->firstEntity);

        $this->entitySetService->update([$this->firstEntity], [$this->updatedEntity]);

        $readEntities = $this->readSet([$this->updatedEntity->getUuid()->getHumanReadable()]);
        $this->compareObjects($readEntities[0], $this->updatedEntity);

        $this->entitySetService->delete([$this->updatedEntity]);

        $this->readFails($this->firstEntity->getUuid()->getHumanReadable());
        $this->readFails($this->updatedEntity->getUuid()->getHumanReadable());
    }

    private function compareObjects($first, $second) {

        $class = new \ReflectionClass($first);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach($methods as $oneMethod) {

            $name = $oneMethod->getName();
            if (strpos($name, 'get') !== 0) {
                continue;
            }

            if ($oneMethod->getNumberOfParameters() != 0) {
                continue;
            }

            $firstSub = $first->$name();
            $secondSub = $second->$name();

            if (is_array($firstSub)) {
                $this->phpunit->assertTrue(is_array($secondSub));
                $this->compareArrays($firstSub, $secondSub);
                continue;
            }

            if (is_object($firstSub)) {
                $this->phpunit->assertTrue(is_object($secondSub));
                $this->compareObjects($firstSub, $secondSub);
                continue;
            }

            $this->phpunit->assertEquals($firstSub, $secondSub);

        }

    }

    private function compareArrays(array $first, array $second) {

        $getSameFromUuid = function(Uuid $uuid, array $data) {
            foreach($data as $oneEntity) {

                if (!($oneEntity instanceof Entity)) {
                    continue;
                }

                if ($uuid->get() == $oneEntity->getUuid()->get()) {
                    return $oneEntity;
                }

            }

            return null;
        };

        foreach($first as $keyname => $oneFirst) {

            if (is_array($oneFirst)) {
                $this->phpunit->assertTrue(is_array($second[$keyname]));
                $this->compareArrays($oneFirst, $second[$keyname]);
                continue;
            }

            if ($oneFirst instanceof Entity) {
                $sameSecond = $getSameFromUuid($oneFirst->getUuid(), $second);
                $this->compareObjects($oneFirst, $sameSecond);
                continue;
            }

            $this->phpunit->assertEquals($oneFirst, $second[$keyname]);

        }
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
