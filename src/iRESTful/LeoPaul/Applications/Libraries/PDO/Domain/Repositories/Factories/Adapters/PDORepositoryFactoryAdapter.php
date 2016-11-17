<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\Adapters;

interface PDORepositoryFactoryAdapter {
    public function fromDataToPDORepositoryFactory(array $data);
}
