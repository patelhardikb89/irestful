<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Services;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class PDOEntitySetService implements EntitySetService {
    private $requestEntityAdapter;
    private $pdoService;
    public function __construct(RequestEntityAdapter $requestEntityAdapter, PDOService $pdoService) {
        $this->requestEntityAdapter = $requestEntityAdapter;
        $this->pdoService = $pdoService;
    }

    public function insert(array $entities) {

        try {
            
            $requests = $this->requestEntityAdapter->fromEntitiesToInsertRequests($entities);
            $this->pdoService->queries($requests);

        } catch (RequestEntityException $exception) {
            throw new EntitySetException('There was an exception while converting Entity objects to an insert request.', $exception);
        } catch (PDOException $exception) {
            throw new EntitySetException('There was an exception while executing queries on the PDOService object.', $exception);
        }
    }

    public function update(array $originalEntities, array $updatedEntities) {

        try {

            $requests = $this->requestEntityAdapter->fromEntitiesToUpdateRequests($originalEntities, $updatedEntities);
            $this->pdoService->queries($requests);

        } catch (RequestEntityException $exception) {
            throw new EntitySetException('There was an exception while converting Entity objects to an update request.', $exception);
        } catch (PDOException $exception) {
            throw new EntitySetException('There was an exception while executing queries on the PDOService object.', $exception);
        }

    }

    public function delete(array $entities) {

        try {

            $requests = $this->requestEntityAdapter->fromEntitiesToDeleteRequests($entities);
            $this->pdoService->queries($requests);

        } catch (RequestEntityException $exception) {
            throw new EntitySetException('There was an exception while converting Entity objects to a delete request.', $exception);
        } catch (PDOException $exception) {
            throw new EntitySetException('There was an exception while executing queries on the PDOService object.', $exception);
        }

    }

}
