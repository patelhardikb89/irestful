<?php
namespace iRESTful\Rodson\ClassesEntitiesAnnotations\Infrastructure\Factories;
use iRESTful\Rodson\ClassesEntitiesAnnotations\Domain\Adapters\Factories\AnnotatedEntityAdapterFactory;
use iRESTful\Rodson\ClassesEntities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\Rodson\Annotations\Infrastructure\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteSampleAdapter;
use iRESTful\Rodson\ClassesEntitiesAnnotations\Infrastructure\Adapters\ConcreteAnnotatedEntityAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories\ConcreteDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Factories\V4UuidFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntitySampleReferenceAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntitySampleAdapter;

final class ConcreteAnnotatedEntityAdapterFactory implements AnnotatedEntityAdapterFactory {
    private $baseNamespace;
    private $timezone;
    public function __construct(array $baseNamespace, $timezone) {
        $this->baseNamespace = $baseNamespace;
        $this->timezone = $timezone;
    }

    public function create() {

        $entityAdapterFactory = new ConcreteEntityAdapterFactory($this->baseNamespace);
        $entityAdapter = $entityAdapterFactory->create();

        $annotationAdapterFactory = new ConcreteAnnotationAdapterFactory($this->baseNamespace);
        $annotationAdapter = $annotationAdapterFactory->create();

        $dateTimeAdapter = new ConcreteDateTimeAdapter($this->timezone);
        $dateTimeFactory = new ConcreteDateTimeFactory($dateTimeAdapter);
        $uuidFactory = new V4UuidFactory();

        $referenceAdapter = new ConcreteEntitySampleReferenceAdapter();
        $dslSampleAdapter = new ConcreteEntitySampleAdapter($uuidFactory, $dateTimeFactory, $referenceAdapter, []);

        $sampleAdapter = new ConcreteSampleAdapter();

        return new ConcreteAnnotatedEntityAdapter($dslSampleAdapter, $sampleAdapter, $entityAdapter, $annotationAdapter);
    }

}
