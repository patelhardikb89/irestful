<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes;

interface SampleNode {
    public function getSamples();
    public function hasSampleByName(string $name);
    public function getSampleByName(string $name);
}
