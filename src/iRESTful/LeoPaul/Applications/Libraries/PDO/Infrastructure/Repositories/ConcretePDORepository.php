<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Exceptions\RequestException;

final class ConcretePDORepository implements PDORepository {
    private $pdoAdapter;
    private $pdoService;
    private $requestAdapter;
    public function __construct(PDOAdapter $pdoAdapter, PDOService $pdoService, RequestAdapter $requestAdapter) {
        $this->pdoAdapter = $pdoAdapter;
        $this->pdoService = $pdoService;
        $this->requestAdapter = $requestAdapter;
    }

    public function fetch(array $request) {
        return $this->execute($request, 'fetchAll');
    }

	public function fetchFirst(array $request) {
        return $this->execute($request, 'fetch');
    }

    private function execute(array $data, $methodNameOnStatement) {

        try {

            $pdoService = $this->pdoService;
            $pdoAdapter = $this->pdoAdapter;
            $request = $this->requestAdapter->fromDataToRequest($data);
            return $this->pdoAdapter->fromDataToPDO([
                'request' => $request,
                'closure' => function() use($data, $methodNameOnStatement, &$pdoService, &$pdoAdapter) {
                    $pdo = $pdoService->query($data);
                    $statement = $pdoAdapter->fromPDOToNativePDOStatement($pdo);
                    return $statement->$methodNameOnStatement();
                }
            ]);

        } catch (RequestException $exception) {
            throw new PDOException('There was an exception while converting the data request into a Request object.', $exception);
        }

    }

}
