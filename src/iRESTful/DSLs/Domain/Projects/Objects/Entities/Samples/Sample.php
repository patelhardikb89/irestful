<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples;

interface Sample {
    public function getName();
    public function hasAdditions();
    public function getAdditions();
    public function hasReferences();
    public function getReferences();
    public function hasNormalizedReferences();
    public function getNormalizedReferences();
}
