<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteRequestEntityAdapter implements RequestEntityAdapter {
    private $entityAdapter;
    private $parentRequestEntityAdapter;
    public function __construct(RequestEntityAdapter $parentRequestEntityAdapter, EntityAdapter $entityAdapter) {
        $this->entityAdapter = $entityAdapter;
        $this->parentRequestEntityAdapter = $parentRequestEntityAdapter;
    }

    public function fromEntityToInsertRequests(Entity $entity) {

        $data = $this->fetchParamsWithContainer($entity);
        $keynames = array_keys($data['params']);
        $values = array_map(function($element) {
            return ':'.$element;
        }, $keynames);

        $parentQueries = $this->parentRequestEntityAdapter->fromEntityToInsertRequests($entity);
        return array_merge([
            [
                'query' => 'insert into '.$data['container'].' ('.implode(', ', $keynames).') values('.implode(', ', $values).');',
                'params' => $data['params']
            ]
        ], $parentQueries);

    }

    public function fromEntitiesToInsertRequests(array $entities) {
        $requests = [];
        foreach($entities as $oneEntity) {
            $singleRequests = $this->fromEntityToInsertRequests($oneEntity);
            $requests = array_merge($requests, $singleRequests);
        }

        return $requests;
    }

    public function fromEntityToUpdateRequests(Entity $originalEntity, Entity $updatedEntity) {

        $originalClass = get_class($originalEntity);
        $updatedClass = get_class($updatedEntity);
        if ($originalClass != $updatedClass) {
            throw new RequestEntityException('The originalEntity (class: '.$originalClass.') must be of the same class as the updatedEntity (class: '.$updatedClass.').');
        }

        $originalUuid = $originalEntity->getUuid();
        $humanOriginalUuid = $originalUuid->getHumanReadable();
        $humanUpdatedEntityUuid = $updatedEntity->getUuid()->getHumanReadable();
        if ($humanOriginalUuid != $humanUpdatedEntityUuid) {
            throw new RequestEntityException('The original Entity Uuid ('.$humanOriginalUuid.') does not match the updated Entity Uuid ('.$humanUpdatedEntityUuid.').');
        }

        $data = $this->fetchParamsWithContainer($updatedEntity, $originalEntity);
        $keynames = array_keys($data['params']);
        $sets = array_map(function($element) {
            return $element.' = :'.$element;
        }, $keynames);

        $binaryOriginalUuid = $originalUuid->get();
        $params = array_merge($data['params'], ['__original_uuid__' => $binaryOriginalUuid]);
        $parentQueries = $this->parentRequestEntityAdapter->fromEntityToUpdateRequests($originalEntity, $updatedEntity);
        return array_merge($parentQueries, [
            [
                'query' => 'update '.$data['container'].' set '.implode(', ', $sets).' where uuid = :__original_uuid__;',
                'params' => $params
            ]
        ]);

    }

    public function fromEntitiesToUpdateRequests(array $originalEntities, array $updatedEntities) {

        $amountOriginalEntities = count($originalEntities);
        $amountUpdatedEntities = count($updatedEntities);
        if ($amountOriginalEntities != $amountUpdatedEntities) {
            throw new RequestEntityException('There must be as many originalEntities ('.$amountOriginalEntities.') as updatedEntities ('.$amountUpdatedEntities.').');
        }

        $requests = [];
        foreach($originalEntities as $index => $oneOriginalEntity) {
            $singleRequests = $this->fromEntityToUpdateRequests($oneOriginalEntity, $updatedEntities[$index]);
            $requests = array_merge($requests, $singleRequests);
        }

        return $requests;

    }

    public function fromEntityToDeleteRequests(Entity $entity) {

        try {

            $containerName = $this->entityAdapter->fromEntityToContainerName($entity);
            $uuid = $entity->getUuid()->get();

            $parentQueries = $this->parentRequestEntityAdapter->fromEntityToDeleteRequests($entity);
            return array_merge($parentQueries, [
                [
                    'query' => 'delete from '.$containerName.' where uuid = :uuid;',
                    'params' => ['uuid' => $uuid]
                ]
            ]);

        } catch (EntityException $exception) {
            throw new RequestEntityException('There was an exception while converting an Entity object to a containerName.', $exception);
        }
    }

    public function fromEntitiesToDeleteRequests(array $entities) {
        $requests = [];
        foreach($entities as $oneEntity) {
            $entityRequests = $this->fromEntityToDeleteRequests($oneEntity);
            $requests = array_merge($requests, $entityRequests);
        }

        return $requests;
    }

    public function fromEntityToParentDeleteRequests(Entity $entity) {
        return $this->parentRequestEntityAdapter->fromEntityToDeleteRequests($entity);
    }

    public function fromEntitiesToParentDeleteRequests(array $entities) {
        return $this->parentRequestEntityAdapter->fromEntitiesToDeleteRequests($entities);
    }

    private function fetchParamsWithContainer(Entity $entity, Entity $originalEntity = null) {

        $filter = function(array $data, array $originalData = null) {
            $output = [];
            foreach($data as $keyname => $oneElement) {

                if (
                        is_null($oneElement) &&
                        !empty($originalData) &&
                        isset($originalData[$keyname]) &&
                        !is_null($originalData[$keyname])
                ) {

                    if (is_array($originalData[$keyname])) {
                        $originalKeys = array_keys($originalData[$keyname]);
                        $oneOriginalKey = array_pop($originalKeys);
                        if (is_numeric($oneOriginalKey)) {
                            continue;
                        }
                    }

                    $output[$keyname] = null;
                    continue;
                }

                if (is_null($oneElement)) {
                    continue;
                }

                if (!is_array($oneElement)) {
                    $output[$keyname] = $oneElement;
                    continue;
                }

                if (isset($oneElement['uuid'])) {
                    $output[$keyname] = $oneElement['uuid'];
                    continue;
                }
            }

            return $output;

        };

        try {

            $containerName = $this->entityAdapter->fromEntityToContainerName($entity);
            $data = $this->entityAdapter->fromEntityToData($entity, false);

            $originalData = null;
            if (!empty($originalEntity)) {
                $originalData = $this->entityAdapter->fromEntityToData($originalEntity, false);
            }

            $params = $filter($data, $originalData);

            return [
                'container' => $containerName,
                'params' => $params
            ];

        } catch (EntityException $exception) {
            throw new RequestEntityException('There was an exception while converting an Entity object to a containerName and/or data.', $exception);
        }

    }

}
