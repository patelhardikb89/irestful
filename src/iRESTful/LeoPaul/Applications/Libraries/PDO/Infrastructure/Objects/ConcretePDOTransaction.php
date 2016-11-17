<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Transaction;
use iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Exceptions\TransactionException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class ConcretePDOTransaction implements Transaction {
    private $pdo;
    private $microDateTimeClosureAdapter;
    public function __construct(\PDO $pdo, MicroDateTimeClosureAdapter $microDateTimeClosureAdapter) {
        $this->pdo = $pdo;
        $this->microDateTimeClosureAdapter = $microDateTimeClosureAdapter;
    }

    public function execute(\Closure $closure) {

        try {

            if (!$this->pdo->beginTransaction()) {
                throw new TransactionException('There was a problem while trying to begin a transaction on a \PDO object.');
            }

            $microDateTimeClosure = $this->microDateTimeClosureAdapter->fromClosureToMicroDateTimeClosure($closure);
            if (!$this->pdo->commit()) {
                throw new TransactionException('There was a problem while trying to commit a transaction on a \PDO object.', $exception);
            }

            return $microDateTimeClosure;

        } catch (MicroDateTimeClosureException $exception) {

            if (!$this->pdo->rollback()) {
                throw new TransactionException('There was a problem while trying to rollback a transaction on a \PDO object.', $exception);
            }

            throw new TransactionException('There was an exception while executing the transaction.  It has to be rollbacked.', $exception);
        }
    }

}
