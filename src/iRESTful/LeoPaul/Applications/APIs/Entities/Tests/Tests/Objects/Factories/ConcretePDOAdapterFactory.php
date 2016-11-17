<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapter;

final class ConcretePDOAdapterFactory implements PDOAdapterFactory {
    private $entityAdapterAdapter;
    private $entityRepository;
    public function __construct(EntityAdapterAdapter $entityAdapterAdapter, EntityRepository $entityRepository) {
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityRepository = $entityRepository;
    }

    public function create() {
        return new ConcretePDOAdapter($this->entityAdapterAdapter, $this->entityRepository);
    }

}
