<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\Factories\Adapters;

interface PDOAdapterFactoryAdapter {
    public function fromDataToPDOAdapterFactory(array $data);
}
