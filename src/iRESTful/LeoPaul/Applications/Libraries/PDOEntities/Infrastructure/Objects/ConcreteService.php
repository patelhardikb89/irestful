<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Repositories\Repository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Services\Service as ServiceService;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Adapters\Adapter;

final class ConcreteService implements Service {
    private $repository;
    private $service;
    private $adapter;
    public function __construct(Repository $repository, ServiceService $service, Adapter $adapter) {
        $this->repository = $repository;
        $this->service = $service;
        $this->adapter = $adapter;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getService() {
        return $this->service;
    }

    public function getAdapter() {
        return $this->adapter;
    }

}
