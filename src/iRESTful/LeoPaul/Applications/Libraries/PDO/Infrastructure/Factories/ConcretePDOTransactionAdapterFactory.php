<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Transactions\Adapters\Factories\TransactionAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories\ConcreteMicroDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteMicroDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteTransactionAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteMicroDateTimeClosureAdapter;

final class ConcretePDOTransactionAdapterFactory implements TransactionAdapterFactory {
    private $timeZone;
    public function __construct($timeZone) {
        $this->timeZone = $timeZone;
    }

    public function create() {
        $dateTimeAdapter = new ConcreteDateTimeAdapter($this->timeZone);
        $microDateTimeAdapter = new ConcreteMicroDateTimeAdapter($dateTimeAdapter);
        $microDateTimeFactory = new ConcreteMicroDateTimeFactory($microDateTimeAdapter);
        $microDateTimeClosureAdapter = new ConcreteMicroDateTimeClosureAdapter($microDateTimeFactory);
        return new ConcreteTransactionAdapter($microDateTimeClosureAdapter);
    }

}
