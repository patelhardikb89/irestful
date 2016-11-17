<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\Adapters\SampleNodeAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Adapters\SampleAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteEntitySampleNode;

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
