<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\Adapters;

interface EntityRepositoryFactoryAdapter {
    public function fromDataToEntityRepositoryFactory(array $data);
}
