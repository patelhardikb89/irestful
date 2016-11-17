<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Transactions\Adapters;

interface TransactionAdapter {
    public function fromNativePDOToTransaction(\PDO $pdo);
}
