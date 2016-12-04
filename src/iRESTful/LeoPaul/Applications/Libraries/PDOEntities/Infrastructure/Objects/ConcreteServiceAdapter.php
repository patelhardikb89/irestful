<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Adapters\Adapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory;

final class ConcreteServiceAdapter implements Adapter {
    private $entityAdapter;
    private $entityPartialSetAdapter;
    private $objectAdapter;
    public function __construct(
        EntityAdapterFactory $entityAdapterFactory,
        EntityPartialSetAdapterFactory $entityPartialSetAdapterFactory,
        ObjectAdapterFactory $objectAdapterFactory
    ) {
        $this->entityAdapter = $entityAdapterFactory->create();
        $this->entityPartialSetAdapter = $entityPartialSetAdapterFactory->create();
        $this->objectAdapter = $objectAdapterFactory->create();
    }

    public function getEntity() {
        return $this->entityAdapter;
    }

    public function getEntityPartialSet() {
        return $this->entityPartialSetAdapter;
    }

    public function getObject() {
        return $this->objectAdapter;
    }

}
