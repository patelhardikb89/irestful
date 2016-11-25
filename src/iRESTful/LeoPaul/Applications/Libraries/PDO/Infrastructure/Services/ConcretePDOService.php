<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Services;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Exceptions\RequestException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Transactions\Adapters\TransactionAdapter;

final class ConcretePDOService implements PDOService {
    private $transactionAdapter;
    private $pdoAdapter;
    private $requestAdapter;
    private $pdo;
    private $server;
    public function __construct(TransactionAdapter $transactionAdapter, PDOAdapter $pdoAdapter, RequestAdapter $requestAdapter, \PDO $pdo) {
        $this->transactionAdapter = $transactionAdapter;
        $this->pdoAdapter = $pdoAdapter;
        $this->requestAdapter = $requestAdapter;
        $this->pdo = $pdo;
    }

    public function query(array $data) {

        try {

            $request = $this->requestAdapter->fromDataToRequest($data);
            $query = $request->getQuery();
            $params = $request->hasParams() ? $request->getParams() : null;

            return $this->pdoAdapter->fromDataToPDO([
                'request' => $request,
                'closure' => function() use($query, $params) {
                    $statement = $this->pdo->prepare($query);
                    if (!$statement->execute($params)) {
                        throw new PDOException('There was an exception while executing a query on the PDO service.');
                    }

                    return $statement;
                }
            ]);

        } catch (RequestException $exception) {
            throw new PDOException('There was an exception while converting the data request into a Request object.', $exception);
        }

    }

    public function queries(array $data) {

        $current = $this;
        $closure = function() use(&$current, $data) {
            $pdos = [];
            foreach($data as $oneRequest) {
                $pdos[] = $current->query($oneRequest);
            }

            return $pdos;

        };

        $requests = $this->requestAdapter->fromDataToRequests($data);
        $transaction = $this->transactionAdapter->fromNativePDOToTransaction($this->pdo);
        return $this->pdoAdapter->fromDataToPDO([
            'requests' => $requests,
            'closure' => function() use(&$transaction, &$closure) {
                return $transaction->execute($closure);
            }
        ]);

    }

}
