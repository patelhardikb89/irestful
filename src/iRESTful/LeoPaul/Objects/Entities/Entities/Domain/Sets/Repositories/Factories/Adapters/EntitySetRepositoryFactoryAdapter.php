<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\Adapters;

interface EntitySetRepositoryFactoryAdapter {
    public function fromDataToEntitySetRepositoryFactory(array $data);
}
