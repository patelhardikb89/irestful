<?php
namespace iRESTful\Rodson\Applications\Infrastructure\Adapters;
use iRESTful\Rodson\Applications\Domain\Domains\Adapters\DomainAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Project;
use iRESTful\Rodson\ClassesObjectsAnnotations\Domain\Adapters\Factories\AnnotatedObjectAdapterFactory;
use iRESTful\Rodson\ClassesEntitiesAnnotations\Domain\Adapters\Factories\AnnotatedEntityAdapterFactory;
use iRESTful\Rodson\ClassesValues\Domain\Adapters\Factories\ValueAdapterFactory;
use iRESTful\Rodson\Applications\Infrastructure\Objects\ConcreteDomain;

final class ConcreteDomainAdapter implements DomainAdapter {
    private $annotatedObjectAdapterFactory;
    private $annotatedEntityAdapterFactory;
    private $valueAdapterFactory;
    public function __construct(
        AnnotatedObjectAdapterFactory $annotatedObjectAdapterFactory,
        AnnotatedEntityAdapterFactory $annotatedEntityAdapterFactory,
        ValueAdapterFactory $valueAdapterFactory
    ) {
        $this->annotatedObjectAdapterFactory = $annotatedObjectAdapterFactory;
        $this->annotatedEntityAdapterFactory = $annotatedEntityAdapterFactory;
        $this->valueAdapterFactory = $valueAdapterFactory;
    }

    public function fromProjectToDomain(Project $project) {

        $annotatedObjects = [];
        if ($project->hasObjects()) {
            $objects = $project->getObjects();
            $annotatedObjects = $this->annotatedObjectAdapterFactory->create()->fromDSLObjectsToAnnotatedClassObjects($objects);
        }

        $annotatedEntities = [];
        if ($project->hasEntities()) {
            $entities = $project->getEntities();
            $annotatedEntities = $this->annotatedEntityAdapterFactory->create()->fromDSLEntitiesToAnnotatedEntities($entities);
        }

        $valueClasses = [];
        if ($project->hasObjects()) {
            $types = $project->getTypes();
            $valueClasses = $this->valueAdapterFactory->create()->fromTypesToValues($types);
        }

        return new ConcreteDomain($annotatedObjects, $annotatedEntities, $valueClasses);
    }

}
