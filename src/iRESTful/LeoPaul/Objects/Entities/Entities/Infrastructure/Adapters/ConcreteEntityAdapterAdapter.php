<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class ConcreteEntityAdapterAdapter implements EntityAdapterAdapter {
    private $objectAdapter;
    private $classMetaDataRepository;
    public function __construct(ObjectAdapter $objectAdapter, ClassMetaDataRepository $classMetaDataRepository) {
        $this->objectAdapter = $objectAdapter;
        $this->classMetaDataRepository = $classMetaDataRepository;
    }

    public function fromRepositoriesToEntityAdapter(EntityRepository $repository, EntityRelationRepository $entityRelationRepository) {
        return new ConcreteEntityAdapter($repository, $entityRelationRepository, $this->objectAdapter, $this->classMetaDataRepository);
    }

}
