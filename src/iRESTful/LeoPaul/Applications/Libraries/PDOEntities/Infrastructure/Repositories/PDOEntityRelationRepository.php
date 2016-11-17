<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException as InternalPDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters\PDOAdapterAdapter;

final class PDOEntityRelationRepository implements EntityRelationRepository {
    private $requestRelationAdapter;
    private $pdoRepository;
    private $pdoAdapterAdapter;
    public function __construct(RequestRelationAdapter $requestRelationAdapter, PDORepository $pdoRepository, PDOAdapterAdapter $pdoAdapterAdapter) {
        $this->requestRelationAdapter = $requestRelationAdapter;
        $this->pdoRepository = $pdoRepository;
        $this->pdoAdapterAdapter = $pdoAdapterAdapter;
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['slave_container'])) {
            throw new EntityRelationException('The slave_container keyname is mandatory in order to retrieve Entity objects.');
        }

        try {

            $pdoAdapter = $this->pdoAdapterAdapter->fromEntityRelationRepositoryToPDOAdapter($this);
            $request = $this->requestRelationAdapter->fromDataToEntityRelationRequest($criteria);
            $pdo = $this->pdoRepository->fetch($request);
            $entities = $pdoAdapter->fromPDOToEntities($pdo, $criteria['slave_container']);

            if (empty($entities)) {
                return [];
            }

            return $entities;

        } catch (RequestRelationException $exception) {
            throw new EntityRelationException('There was an exception while converting criteria data to a request.', $exception);
        } catch (PDOException $exception) {
            throw new EntityRelationException('There was an exception while fetching Entity objects from the PDORepository.', $exception);
        } catch (InternalPDOException $exception) {
            throw new EntityRelationException('There was an exception while converting a PDO object to Entity objects.', $exception);
        }
    }

}
