<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class ConcreteEntityAdapter implements EntityAdapter {
    private $entityRepository;
    private $entityRelationRepository;
    private $objectAdapter;
    private $classMetaDataRepository;
    private $callBackOnFail;
    public function __construct(
        EntityRepository $entityRepository,
        EntityRelationRepository $entityRelationRepository,
        ObjectAdapter $objectAdapter,
        ClassMetaDataRepository $classMetaDataRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->entityRelationRepository = $entityRelationRepository;
        $this->objectAdapter = $objectAdapter;
        $this->classMetaDataRepository = $classMetaDataRepository;

        $entityRepository = $this->entityRepository;
        $entityRelationRepository = $this->entityRelationRepository;
        $classMetaDataRepository = $this->classMetaDataRepository;
        $this->callBackOnFail = function(array $data) use(&$entityRepository, &$entityRelationRepository, &$classMetaDataRepository) {

            if (
                    isset($data['master_container']) &&
                    isset($data['slave_type']) &&
                    isset($data['slave_property']) &&
                    isset($data['master_uuid'])
            ) {

                $slaveClassMetaData = $this->classMetaDataRepository->retrieve([
                    'class' => $data['slave_type']
                ]);

                if (!$slaveClassMetaData->hasContainerName()) {
                    throw new EntityException('It was impossible to retrieve the related entities (master_container: '.$data['master_container'].', slave_property: '.$data['slave_property'].') because the slave_type ('.$data['slave_type'].') does not have a container.');
                }

                try {

                    $slaveContainer = $slaveClassMetaData->getContainerName();
                    return $entityRelationRepository->retrieve([
                        'master_container' => $data['master_container'],
                        'slave_container' => $slaveContainer,
                        'slave_property' => $data['slave_property'],
                        'master_uuid' => $data['master_uuid']
                    ]);

                } catch (EntityRelationException $exception) {
                    throw new EntityException('There was an exception while retrieving related Entity objects.', $exception);
                }
            }

            if (isset($data['class']) && isset($data['input'])) {
                $interfaces = class_implements($data['class']);
                if (in_array('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity', $interfaces)) {

                    if (is_string($data['input']) && !empty($data['input'])) {
                        $classMetaData = $classMetaDataRepository->retrieve(['class' => $data['class']]);
                        if (!$classMetaData->hasContainerName()) {
                            throw new EntityException('The given class ('.$data['class'].') must have a container in order to retrieve its object from a Uuid string.');
                        }

                        $containerName = $classMetaData->getContainerName();
                        return $entityRepository->retrieve([
                            'container' => $containerName,
                            'uuid' => $data['input']
                        ]);
                    }

                    throw new EntityException('The input was expecting a string (uuid).');
                }

                throw new EntityException('The given className ('.$data['class'].') is not an Entity class.');
            }

            throw new EntityException('The callback request was invalid.');
        };
    }

    public function fromDataToEntity(array $data) {

        try {

            $data['callback_on_fail'] = $this->callBackOnFail;
            return $this->objectAdapter->fromDataToObject($data);

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting data to an object.', $exception);
        }
    }

    public function fromDataToEntities(array $data) {

        try {

            $output = [];
            foreach($data as $index => $oneData) {
                $oneData['callback_on_fail'] = $this->callBackOnFail;
                $output[] = $oneData;
            }

            return $this->objectAdapter->fromDataToObjects($output);

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting data to Entity objects.', $exception);
        }
    }

    public function fromEntityToData(Entity $entity, $isHumanReadable) {
        try {

            return $this->objectAdapter->fromObjectToData($entity, $isHumanReadable);

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting an object to data.', $exception);
        }
    }

    public function fromEntitiesToData(array $entities, $isHumanReadable) {

        try {

            return $this->objectAdapter->fromObjectsToData($entities, $isHumanReadable);

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting Entity objects to data.', $exception);
        }
    }

    public function fromEntityToContainerName(Entity $entity) {

        try {

            $metaData = $this->classMetaDataRepository->retrieve(['object' => $entity]);
            if (!$metaData->hasContainerName()) {
                throw new EntityException('The entity object does not contain a valid container name.');
            }

            return $metaData->getContainerName();

        } catch (ClassMetaDataException $exception) {
            throw new EntityException('There was an exception while retrieving a ClassMetaData object.', $exception);
        }
    }

    public function fromEntitiesToContainerNames(array $entities) {
        $output = [];
        foreach($entities as $oneEntity) {
            $output[] = $this->fromEntityToContainerName($oneEntity);
        }

        return $output;
    }

    public function fromEntityToSubEntities(Entity $entity) {

        try {

            $subObjects = $this->objectAdapter->fromObjectToSubObjects($entity);
            $entities = $this->fromObjectsToEntities($subObjects);
            return $this->fromEntitiesToUniqueEntities($entities);

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting an object to sub objects.', $exception);
        }

    }

    public function fromEntitiesToSubEntities(array $entities) {

        try {

            $subObjects = $this->objectAdapter->fromObjectsToSubObjects($entities);
            $entities = $this->fromObjectsToEntities($subObjects);
            return $this->fromEntitiesToUniqueEntities($entities);

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting an object to sub objects.', $exception);
        }

    }

    public function fromEntityToRelationEntities(Entity $entity) {

        try {

            $relationObjects = $this->objectAdapter->fromObjectToRelationObjects($entity);
            $relationEntities = $this->fromRelationObjectsToRelationEntities($relationObjects);
            return $relationEntities;

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting an object to relation objects.', $exception);
        }

    }

    public function fromEntityToEmptyRelationEntityKeynames(Entity $entity) {
        return $this->objectAdapter->fromObjectToEmptyRelationObjectKeynames($entity);
    }

    public function fromEntitiesToRelationEntitiesList(array $entities) {

        try {

            $relationObjectsList = $this->objectAdapter->fromObjectsToRelationObjectsList($entities);
            $relationEntitiesList = $this->fromRelationObjectsListToRelationEntitiesList($relationObjectsList);
            return $relationEntitiesList;

        } catch (ObjectException $exception) {
            throw new EntityException('There was an exception while converting an object to relation objects.', $exception);
        }

    }

    public function fromEntitiesToUniqueEntities(array $entities) {

        $containsEntity = function(array $entities, Entity $entity) {
            foreach($entities as $oneEntity) {
                if ($oneEntity == $entity) {
                    return true;
                }
            }

            return false;
        };

        $output = [];
        foreach($entities as $oneEntity) {

            if (!$containsEntity($output, $oneEntity)) {
                $output[] = $oneEntity;
            }

        }

        return $output;

    }

    public function fromObjectsToEntities(array $objects) {

        $entities = [];
        foreach($objects as $oneObject) {
            if ($oneObject instanceof Entity) {
                $entities[] = $oneObject;
            }
        }

        return $entities;
    }

    public function fromRelationObjectsToRelationEntities(array $relationObjects) {
        $relationEntities = [];
        foreach($relationObjects as $keyname => $subObjects) {
            $subEntities = $this->fromObjectsToEntities($subObjects);
            if (!empty($subEntities)) {
                $relationEntities[$keyname] = $this->fromEntitiesToUniqueEntities($subEntities);
            }
        }

        return $relationEntities;
    }

    public function fromRelationObjectsListToRelationEntitiesList(array $relationObjectsList) {
        $relationEntitiesList = [];
        foreach($relationObjectsList as $oneRelationObjects) {
            $relationEntitiesList[] = $this->fromRelationObjectsToRelationEntities($oneRelationObjects);
        }

        return $relationEntitiesList;
    }

}
