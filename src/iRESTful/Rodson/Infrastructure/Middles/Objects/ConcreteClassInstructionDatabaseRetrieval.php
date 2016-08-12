<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\HttpRequest;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Entity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\MultipleEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Exceptions\RetrievalException;

final class ConcreteClassInstructionDatabaseRetrieval implements Retrieval {
    private $httpRequest;
    private $entity;
    private $multipleEntity;
    private $entityPartialSet;
    public function __construct(HttpRequest $httpRequest = null, Entity $entity = null, MultipleEntity $multipleEntity = null, EntityPartialSet $entityPartialSet = null) {

        $amount = (empty($httpRequest) ? 0 : 1) + (empty($entity) ? 0 : 1) + (empty($multipleEntity) ? 0 : 1) + (empty($entityPartialSet) ? 0 : 1);
        if ($amount != 1) {
            throw new RetrievalException('One of these must be non-empty: httpRequest, entity, multipleEntity, entityPartialSet.  '.$amount.' given.');
        }

        $this->httpRequest = $httpRequest;
        $this->entity = $entity;
        $this->multipleEntity = $multipleEntity;
        $this->entityPartialSet = $entityPartialSet;

    }

    public function hasHttpRequest() {
        return !empty($this->httpRequest);
    }

    public function getHttpRequest() {
        return $this->httpRequest;
    }

    public function hasEntity() {
        return !empty($this->entity);
    }

    public function getEntity() {
        return $this->entity;
    }

    public function hasMultipleEntities() {
        return !empty($this->multipleEntity);
    }

    public function getMultipleEntities() {
        return $this->multipleEntity;
    }

    public function hasEntityPartialSet() {
        return !empty($this->entityPartialSet);
    }

    public function getEntityPartialSet() {
        return $this->entityPartialSet;
    }

}
