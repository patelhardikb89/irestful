<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Adapters\SubEntitiesAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Exceptions\RequestSubEntitiesException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class ConcreteRequestEntityWithSubEntitiesAdapter implements RequestEntityAdapter {
    private $subEntitySetRepository;
    private $subEntityRepository;
    private $subEntitiesAdapter;
    private $requestEntityAdapter;
    public function __construct(
        SubEntitySetRepository $subEntitySetRepository,
        SubEntityRepository $subEntityRepository,
        SubEntitiesAdapter $subEntitiesAdapter,
        RequestEntityAdapter $requestEntityAdapter
    ) {
        $this->subEntitySetRepository = $subEntitySetRepository;
        $this->subEntityRepository = $subEntityRepository;
        $this->subEntitiesAdapter = $subEntitiesAdapter;
        $this->requestEntityAdapter = $requestEntityAdapter;
    }

    public function fromEntityToInsertRequests(Entity $entity) {

        try {

            $subEntities = $this->subEntityRepository->retrieve($entity);
            $requests =  $this->requestEntityAdapter->fromEntityToInsertRequests($entity);

            if (!empty($subEntities)) {
                $subRequests = $this->subEntitiesAdapter->fromSubEntitiesToRequests($subEntities);
                return array_merge($subRequests['update'], $subRequests['insert'], $requests);
            }

            return $requests;

        } catch (RequestSubEntitiesException $exception) {
            throw new RequestEntityException('There was an exception while converting a SubEntities object to requests.', $exception);
        } catch (SubEntityException $exception) {
            throw new RequestEntityException('There was an exception while retrieving a SubEntities object.', $exception);
        }
    }

    public function fromEntitiesToInsertRequests(array $entities) {

        try {

            $subEntities = $this->subEntitySetRepository->retrieve($entities);
            $requests =  $this->requestEntityAdapter->fromEntitiesToInsertRequests($entities);

            if (!empty($subEntities)) {
                $subRequests = $this->subEntitiesAdapter->fromSubEntitiesToRequests($subEntities);
                return array_merge($subRequests['update'], $subRequests['insert'], $requests);
            }

            return $requests;

        } catch (RequestSubEntitiesException $exception) {
            throw new RequestEntityException('There was an exception while converting a SubEntities object to requests.', $exception);
        } catch (SubEntityException $exception) {
            throw new RequestEntityException('There was an exception while retrieving a SubEntities object.', $exception);
        }

    }

    public function fromEntityToUpdateRequests(Entity $originalEntity, Entity $updatedEntity) {

        try {

            $subEntities = $this->subEntityRepository->retrieve($updatedEntity);
            $requests =  $this->requestEntityAdapter->fromEntityToUpdateRequests($originalEntity, $updatedEntity);
            $deleteSubRequests = $this->requestEntityAdapter->fromEntityToParentDeleteRequests($originalEntity);

            if (!empty($subEntities)) {
                $subRequests = $this->subEntitiesAdapter->fromSubEntitiesToRequests($subEntities);
                return array_merge($deleteSubRequests, $subRequests['insert'], $subRequests['update'], $requests);
            }


            return array_merge($deleteSubRequests, $requests);

        } catch (RequestSubEntitiesException $exception) {
            throw new RequestEntityException('There was an exception while converting a SubEntities object to requests.', $exception);
        } catch (SubEntityException $exception) {
            throw new RequestEntityException('There was an exception while retrieving a SubEntities object.', $exception);
        }
    }

    public function fromEntitiesToUpdateRequests(array $originalEntities, array $updatedEntities) {

        try {

            $subEntities = $this->subEntitySetRepository->retrieve($updatedEntities);
            $requests =  $this->requestEntityAdapter->fromEntitiesToUpdateRequests($originalEntities, $updatedEntities);
            $deleteSubRequests = $this->requestEntityAdapter->fromEntitiesToParentDeleteRequests($originalEntities);
            
            if (!empty($subEntities)) {
                $subRequests = $this->subEntitiesAdapter->fromSubEntitiesToRequests($subEntities);
                return array_merge($deleteSubRequests, $subRequests['insert'], $subRequests['update'], $requests);
            }


            return array_merge($deleteSubRequests, $requests);

        } catch (RequestSubEntitiesException $exception) {
            throw new RequestEntityException('There was an exception while converting a SubEntities object to requests.', $exception);
        } catch (SubEntityException $exception) {
            throw new RequestEntityException('There was an exception while retrieving a SubEntities object.', $exception);
        }
    }

    public function fromEntityToDeleteRequests(Entity $entity) {
        return $this->requestEntityAdapter->fromEntityToDeleteRequests($entity);
    }

    public function fromEntitiesToDeleteRequests(array $entities) {
        return $this->requestEntityAdapter->fromEntitiesToDeleteRequests($entities);
    }

    public function fromEntityToParentDeleteRequests(Entity $entity) {
        return $this->requestEntityAdapter->fromEntityToDeleteRequests($entity);
    }

    public function fromEntitiesToParentDeleteRequests(array $entities) {
        return $this->requestEntityAdapter->fromEntitiesToDeleteRequests($entities);
    }
}
