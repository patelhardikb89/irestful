<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteSubEntities;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class ConcreteSubEntityRepository implements SubEntityRepository {
    private $entityRepository;
    private $entityAdapter;
    public function __construct(EntityRepository $entityRepository, EntityAdapter $entityAdapter) {
        $this->entityRepository = $entityRepository;
        $this->entityAdapter = $entityAdapter;
    }

    public function retrieve(Entity $entity) {

        try {

            $entities = $this->entityAdapter->fromEntityToSubEntities($entity);
            if (empty($entities)) {
                return null;
            }

            $existingSubEntities = [];
            $newSubEntities = [];
            $containerNames = $this->entityAdapter->fromEntitiesToContainerNames($entities);
            foreach($entities as $index => $oneEntity) {

                $exists = $this->entityRepository->exists([
                    'container' => $containerNames[$index],
                    'uuid' => $oneEntity->getUuid()->getHumanReadable()
                ]);

                if ($exists) {
                    $existingSubEntities[] = $oneEntity;
                    continue;
                }

                $newSubEntities[] = $oneEntity;
            }

            return new ConcreteSubEntities($existingSubEntities, $newSubEntities);

        } catch (EntityException $exception) {
            throw new SubEntityException('There was an exception while converting an Entity to sub Entity object, when converting Entity objects to containerNames or when verifying if an Entity exists.', $exception);
        }

    }

}
