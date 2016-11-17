<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Transactions\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\Transactions\Tests\Helpers\Objects\TransactionHelper;
use iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Exceptions\TransactionException;

final class TransactionHelperTest extends \PHPUnit_Framework_TestCase {
    private $transactionMock;
    private $microDateTimeClosureMock;
    private $closure;
    private $helper;
    public function setUp() {
        $this->transactionMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Transaction');
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');

        $this->closure = function() {

        };

        $this->helper = new TransactionHelper($this, $this->transactionMock );
    }

    public function tearDown() {

    }

    public function testExecute_Success() {

        $this->helper->expectsExecute_Success($this->microDateTimeClosureMock, $this->closure);

        $microDateTimeCosure = $this->transactionMock->execute($this->closure);

        $this->assertEquals($this->microDateTimeClosureMock, $microDateTimeCosure);

    }

    public function testExecute_throwsTransactionException() {

        $this->helper->expectsExecute_throwsTransactionException($this->closure);

        $asserted = false;
        try {

            $this->transactionMock->execute($this->closure);

        } catch (TransactionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
