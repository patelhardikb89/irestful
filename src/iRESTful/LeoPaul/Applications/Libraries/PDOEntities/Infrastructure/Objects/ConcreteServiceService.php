<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Services\Service;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;

final class ConcreteServiceService implements Service {
    private $service;
    private $setService;
    public function __construct(EntityServiceFactory $serviceFactory, EntitySetServiceFactory $setServiceFactory) {
        $this->service = $serviceFactory->create();
        $this->setService = $setServiceFactory->create();
    }

    public function getEntity() {
        return $this->service;
    }

    public function getEntitySet() {
        return $this->setService;
    }

}
