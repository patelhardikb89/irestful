<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class ConcreteRequestEntityRelationAdapter implements RequestEntityAdapter {
    private $entityAdapter;
    private $tableDelimiter;
    public function __construct(EntityAdapter $entityAdapter, $tableDelimiter) {
        $this->entityAdapter = $entityAdapter;
        $this->tableDelimiter = $tableDelimiter;
    }

    public function fromEntityToInsertRequests(Entity $entity) {

        try {

            $requests = [];
            $masterUuid = $entity->getUuid()->get();
            $containerName = $this->entityAdapter->fromEntityToContainerName($entity);
            $relationEntities = $this->entityAdapter->fromEntityToRelationEntities($entity);
            foreach($relationEntities as $keyname => $subEntities) {

                $table = $containerName.$this->tableDelimiter.$keyname;
                $requests[] = $this->createDeleteRequest($table, $masterUuid);

                foreach($subEntities as $oneSubEntity) {
                    $slaveUuid = $oneSubEntity->getUuid()->get();
                    $requests[] = [
                        'query' => 'insert into '.$table.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                        'params' => [
                            ':master_uuid' => $masterUuid,
                            ':slave_uuid' => $slaveUuid
                        ]
                    ];
                }

            }

            return $requests;

        } catch (EntityException $exception) {
            throw new RequestEntityException('There was an exeption while converting an Entity to a containerName and/or relation entities.', $exception);
        }

    }

    public function fromEntitiesToInsertRequests(array $entities) {

        $requests = [];
        foreach($entities as $oneEntity) {
            $entityRequests = $this->fromEntityToInsertRequests($oneEntity);
            $requests = array_merge($requests, $entityRequests);
        }

        return $requests;

    }

    public function fromEntityToUpdateRequests(Entity $originalEntity, Entity $updatedEntity) {
        $deleteRequests = $this->fromEntityToDeleteRequests($originalEntity);
        $insertRequests = $this->fromEntityToInsertRequests($updatedEntity);
        return array_merge($deleteRequests, $insertRequests);
    }

    public function fromEntitiesToUpdateRequests(array $originalEntities, array $updatedEntities) {

        $requests = [];
        $indexes = array_keys($originalEntities);
        foreach($indexes as $oneIndex) {
            $entityRequests = $this->fromEntityToUpdateRequests($originalEntities[$oneIndex], $updatedEntities[$oneIndex]);
            $requests = array_merge($requests, $entityRequests);
        }

        return $requests;

    }

    public function fromEntityToDeleteRequests(Entity $entity) {

        try {

            $requests = [];
            $masterUuid = $entity->getUuid()->get();
            $containerName = $this->entityAdapter->fromEntityToContainerName($entity);
            $relationEntities = $this->entityAdapter->fromEntityToRelationEntities($entity);

            if (!empty($relationEntities)) {
                $keynames = array_keys($relationEntities);
                foreach($keynames as $oneKeyname) {
                    $table = $containerName.$this->tableDelimiter.$oneKeyname;
                    $requests[] = $this->createDeleteRequest($table, $masterUuid);
                }
            }

            $relatedKeynames = $this->entityAdapter->fromEntityToEmptyRelationEntityKeynames($entity);
            if (!empty($relatedKeynames)) {
                foreach($relatedKeynames as $oneRelatedKeyname) {
                    $table = $containerName.$this->tableDelimiter.$oneRelatedKeyname;
                    $requests[] = $this->createDeleteAllRequest($table);
                }
            }

            return $requests;

        } catch (EntityException $exception) {
            throw new RequestEntityException('There was an exeption while converting an Entity to a containerName and/or relation entities.', $exception);
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
        return [];
    }

    public function fromEntitiesToParentDeleteRequests(array $entities) {
        return [];
    }

    private function createDeleteRequest($table, $masterUuid) {
        return [
            'query' => 'delete from '.$table.' where master_uuid = :uuid;',
            'params' => [
                ':uuid' => $masterUuid
            ]
        ];
    }

    private function createDeleteAllRequest($table) {
        return [
            'query' => 'delete from '.$table.';'
        ];
    }

}
