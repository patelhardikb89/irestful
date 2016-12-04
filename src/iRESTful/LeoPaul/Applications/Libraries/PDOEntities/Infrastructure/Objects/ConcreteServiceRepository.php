<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Repositories\Repository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;

final class ConcreteServiceRepository implements Repository {
    private $repository;
    private $setRepository;
    private $partialSetRepository;
    private $relationRepository;
    public function __construct(
        EntityRepositoryFactory $repositoryFactory,
        EntitySetRepositoryFactory $setRepositoryFactory,
        EntityPartialSetRepositoryFactory $partialSetRepositoryFactory,
        EntityRelationRepositoryFactory $relationRepositoryFactory
    ) {
        $this->repository = $repositoryFactory->create();
        $this->setRepository = $setRepositoryFactory->create();
        $this->partialSetRepository = $partialSetRepositoryFactory->create();
        $this->relationRepository = $relationRepositoryFactory->create();
    }

    public function getEntity() {
        return $this->repository;
    }

    public function getEntitySet() {
        return $this->setRepository;
    }

    public function getEntityPartialSet() {
        return $this->partialSetRepository;
    }

    public function getEntityRelation() {
        return $this->relationRepository;
    }

}
