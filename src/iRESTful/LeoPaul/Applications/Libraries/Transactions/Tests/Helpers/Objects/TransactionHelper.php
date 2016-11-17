<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Transactions\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Transaction;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure;
use iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Exceptions\TransactionException;

final class TransactionHelper {
    private $phpunit;
    private $transactionMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Transaction $transactionMock) {
        $this->phpunit = $phpunit;
        $this->transactionMock = $transactionMock;
    }

    public function expectsExecute_Success(MicroDateTimeClosure $returnedMicroDateTimeClosure, \Closure $closure) {
        $this->transactionMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($closure)
                                ->will($this->phpunit->returnValue($returnedMicroDateTimeClosure));
    }

    public function expectsExecute_throwsTransactionException(\Closure $closure) {
        $this->transactionMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($closure)
                                ->will($this->phpunit->throwException(new TransactionException('TEST')));
    }

}
