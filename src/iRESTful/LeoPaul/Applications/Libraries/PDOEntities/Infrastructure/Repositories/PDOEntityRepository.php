<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters\PDOAdapterAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Exceptions\RequestException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException as InternalPDOException;

final class PDOEntityRepository implements EntityRepository {
	private $pdoRepository;
	private $requestAdapter;
    private $pdoAdapter;
    private $pdoAdapterAdapter;
	public function __construct(PDORepository $pdoRepository, RequestAdapter $requestAdapter) {
		$this->pdoRepository = $pdoRepository;
		$this->requestAdapter = $requestAdapter;
        $this->pdoAdapterAdapter = null;
        $this->pdoAdapter = null;
	}

    public function addPDOAdapterAdapter(PDOAdapterAdapter $pdoAdapterAdapter) {
        $this->pdoAdapterAdapter = $pdoAdapterAdapter;
        return $this;
    }

    private function init() {

        if (empty($this->pdoAdapterAdapter)) {
            throw new EntityException('The pdoAdapterAdapter object must be added (using the addPDOAdapterAdapter method) before using the EntityRepository.');
        }

        if (empty($this->pdoAdapter)) {
            $this->pdoAdapter = $this->pdoAdapterAdapter->fromEntityRepositoryToPDOAdapter($this);
        }

    }

	public function exists(array $criteria) {
        $this->init();
        $entity = $this->retrieve($criteria);
        return !empty($entity);
	}

    public function retrieve(array $criteria) {

        if (!isset($criteria['container'])) {
            throw new EntityException('The container keyname is mandatory in order to retrieve an Entity object.');
        }

        $this->init();

        try {

    		$request = $this->requestAdapter->fromDataToEntityRequest($criteria);
            $pdo = $this->pdoRepository->fetchFirst($request);
            return $this->pdoAdapter->fromPDOToEntity($pdo, $criteria['container']);

        } catch (RequestException $exception) {
            throw new EntityException('There was an exception while converting data to a Request.', $exception);
        } catch (PDOException $exception) {
            throw new EntityException('There was an exception while fetching the first data from the PDORepository object.', $exception);
        } catch (InternalPDOException $exception) {
            throw new EntityException('There was an exception while converting a PDO object to an Entity object.', $exception);
        }
	}

}
