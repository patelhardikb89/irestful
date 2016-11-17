<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository;

final class ConcreteSubEntitySetRepository implements SubEntitySetRepository {
    private $subEntityRepository;
    public function __construct(SubEntityRepository $subEntityRepository) {
        $this->subEntityRepository = $subEntityRepository;
    }

    public function retrieve(array $entities) {
        $subEntities = null;
        foreach($entities as $oneEntity) {
            $oneSubEntities = $this->subEntityRepository->retrieve($oneEntity);

            if (empty($oneSubEntities)) {
                continue;
            }

            if (empty($subEntities)) {
                $subEntities = $oneSubEntities;
                continue;
            }

            $subEntities = $subEntities->merge($oneSubEntities);
        }

        return $subEntities;
    }

}
