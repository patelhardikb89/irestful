<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class PDOEntityService implements EntityService {
    private $requestEntityAdapter;
    private $pdoService;
    public function __construct(RequestEntityAdapter $requestEntityAdapter, PDOService $pdoService) {
        $this->requestEntityAdapter = $requestEntityAdapter;
        $this->pdoService = $pdoService;
    }

    public function insert(Entity $entity) {

        try {

            $requests = $this->requestEntityAdapter->fromEntityToInsertRequests($entity);
            $this->pdoService->queries($requests);

        } catch (RequestEntityException $exception) {
            throw new EntityException('There was an exception while converting an Entity object to insert requests.', $exception);
        } catch (PDOException $exception) {
            throw new EntityException('There was an exception while executing queries on the PDOService object.', $exception);
        }

    }

    public function update(Entity $originalEntity, Entity $updatedEntity) {

        try {

            $requests = $this->requestEntityAdapter->fromEntityToUpdateRequests($originalEntity, $updatedEntity);
            $this->pdoService->queries($requests);

        } catch (RequestEntityException $exception) {
            throw new EntityException('There was an exception while converting an Entity object to update requests.', $exception);
        } catch (PDOException $exception) {
            throw new EntityException('There was an exception while executing queries on the PDOService object.', $exception);
        }
    }

    public function delete(Entity $entity) {

        try {

            $requests = $this->requestEntityAdapter->fromEntityToDeleteRequests($entity);
            $this->pdoService->queries($requests);

        } catch (RequestEntityException $exception) {
            throw new EntityException('There was an exception while converting an Entity object to a delete request.', $exception);
        } catch (PDOException $exception) {
            throw new EntityException('There was an exception while executing queries on the PDOService object.', $exception);
        }
    }

}
