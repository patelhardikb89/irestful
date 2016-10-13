<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets;

interface EntityPartialSet {
    public function getContainer();
    public function getIndexValue();
    public function getAmountValue();
}
