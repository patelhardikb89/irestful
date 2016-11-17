<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException as InternalPDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;

final class PDOEntityPartialSetRepository implements EntityPartialSetRepository {
    private $requestPartialSetAdapter;
    private $entityPartialSetAdapter;
    private $pdoRepository;
    private $pdoAdapterFactory;
    public function __construct(RequestPartialSetAdapter $requestPartialSetAdapter, EntityPartialSetAdapter $entityPartialSetAdapter, PDORepository $pdoRepository, PDOAdapterFactory $pdoAdapterFactory) {
        $this->requestPartialSetAdapter = $requestPartialSetAdapter;
        $this->entityPartialSetAdapter = $entityPartialSetAdapter;
        $this->pdoRepository = $pdoRepository;
        $this->pdoAdapterFactory = $pdoAdapterFactory;
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['index'])) {
            throw new EntityPartialSetException('The index keyname is mandatory in the criteria in order to retrieve an EntityPartialSet object.');
        }

        if (!isset($criteria['container'])) {
            throw new EntityPartialSetException('The container keyname is mandatory in the criteria in order to retrieve an EntityPartialSet object.');
        }

        $pdoRepository = $this->pdoRepository;
        $pdoAdapter = $this->pdoAdapterFactory->create();
        $retrieveTotalAmount = function(array $request, $containerName) use(&$pdoRepository, &$pdoAdapter) {

            $pdo = $pdoRepository->fetchFirst($request);
            $results = $pdoAdapter->fromPDOToResults($pdo, $containerName);
            if (!isset($results['amount'])) {
                throw new EntityPartialSetException('The amount was supposed to be in the results in order to retrieve the totalAmount of elements in the given containerName.');
            }

            return $results['amount'];
        };

        try {

            $request = $this->requestPartialSetAdapter->fromDataToEntityPartialSetRequest($criteria);
            $totalAmountRequest = $this->requestPartialSetAdapter->fromDataToEntityPartialSetTotalAmountRequest($criteria);

            $pdo = $this->pdoRepository->fetch($request);
            $entities = $pdoAdapter->fromPDOToEntities($pdo, $criteria['container']);
            $totalAmount = $retrieveTotalAmount($totalAmountRequest, $criteria['container']);
            return $this->entityPartialSetAdapter->fromDataToEntityPartialSet([
                'index' => $criteria['index'],
                'total_amount' => $totalAmount,
                'entities' => $entities
            ]);

        } catch (RequestPartialSetException $exception) {
            throw new EntityPartialSetException('There was an exception while converting data to a request.', $exception);
        } catch (InternalPDOException $exception) {
            throw new EntityPartialSetException('There was an exception while converting a PDO object to Entity objects or results.', $exception);
        } catch (PDOException $exception) {
            throw new EntityPartialSetException('There was an exception while retrieving data from a PDORepository.', $exception);
        }

    }

}
