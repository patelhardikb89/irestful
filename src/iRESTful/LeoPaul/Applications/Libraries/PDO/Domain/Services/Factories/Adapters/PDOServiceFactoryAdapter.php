<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\Adapters;

interface PDOServiceFactoryAdapter {
    public function fromDataToPDOServiceFactory(array $data);
}
