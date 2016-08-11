<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\EntityPartialSets;

interface EntityPartialSet {
    public function getObject();
    public function getMinimumValue();
    public function getMaximumValue();
}
