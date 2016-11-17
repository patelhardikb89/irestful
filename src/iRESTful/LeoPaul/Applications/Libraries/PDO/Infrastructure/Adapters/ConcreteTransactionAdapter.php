<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Transactions\Adapters\TransactionAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcretePDOTransaction;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter;

final class ConcreteTransactionAdapter implements TransactionAdapter {
    private $microDateTimeClosureAdapter;
    public function __construct(MicroDateTimeClosureAdapter $microDateTimeClosureAdapter) {
        $this->microDateTimeClosureAdapter = $microDateTimeClosureAdapter;
    }

    public function fromNativePDOToTransaction(\PDO $pdo) {
        return new ConcretePDOTransaction($pdo, $this->microDateTimeClosureAdapter);
    }

}
