<?php
namespace iRESTful\Applications\Infrastructure\Adapters;
use iRESTful\Applications\Domain\Domains\Adapters\DomainAdapter;
use iRESTful\DSLs\Domain\Projects\Project;
use iRESTful\ClassesObjectsAnnotations\Domain\Adapters\Factories\AnnotatedObjectAdapterFactory;
use iRESTful\ClassesEntitiesAnnotations\Domain\Adapters\Factories\AnnotatedEntityAdapterFactory;
use iRESTful\ClassesValues\Domain\Adapters\Factories\ValueAdapterFactory;
use iRESTful\Applications\Infrastructure\Objects\ConcreteDomain;

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
