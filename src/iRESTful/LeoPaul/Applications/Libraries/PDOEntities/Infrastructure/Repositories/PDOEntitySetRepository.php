<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Exceptions\RequestSetException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException as InternalPDOException;

final class PDOEntitySetRepository implements EntitySetRepository {
    private $pdoRepository;
    private $requestSetAdapter;
    private $pdoAdapterFactory;
    public function __construct(PDORepository $pdoRepository, RequestSetAdapter $requestSetAdapter, PDOAdapterFactory $pdoAdapterFactory) {
        $this->pdoRepository = $pdoRepository;
        $this->requestSetAdapter = $requestSetAdapter;
        $this->pdoAdapterFactory = $pdoAdapterFactory;
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['container'])) {
            throw new EntitySetException('The container keyname is mandatory in order to retrieve Entity objects.');
        }

        try {

            $request = $this->requestSetAdapter->fromDataToEntitySetRequest($criteria);
            $pdo = $this->pdoRepository->fetch($request);
            $entities = $this->pdoAdapterFactory->create()->fromPDOToEntities($pdo, $criteria['container']);
            if (empty($entities)) {
                return [];
            }

            return $entities;

        } catch (RequestSetException $exception) {
            throw new EntitySetException('There was an exception while converting data to a Request.', $exception);
        } catch (PDOException $exception) {
            throw new EntitySetException('There was an exception while fetching data from the PDORepository object.', $exception);
        } catch (InternalPDOException $exception) {
            throw new EntitySetException('There was an exception while converting a PDO object to an Entity objects.', $exception);
        }
    }

}
