<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\Adapters\SampleNodeAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\Adapters\SampleAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteEntitySampleNode;

final class ConcreteEntitySampleNodeAdapter implements SampleNodeAdapter {
    private $sampleAdapter;
    private $uuidFactory;
    private $dateTimeFactory;
    public function __construct(SampleAdapter $sampleAdapter) {
        $this->sampleAdapter = $sampleAdapter;
    }

    public function fromDataToSampleNode(array $data) {
        $samples =  $this->sampleAdapter->fromDataToSamples($data);
        return new ConcreteEntitySampleNode($samples);
    }

}
