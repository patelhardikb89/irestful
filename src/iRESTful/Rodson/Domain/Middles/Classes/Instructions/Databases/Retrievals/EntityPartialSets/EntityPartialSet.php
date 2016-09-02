<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets;

interface EntityPartialSet {
    public function getContainer();
    public function getIndexValue();
    public function getAmountValue();
    public function getData();
}
