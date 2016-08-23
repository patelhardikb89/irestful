<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets;

interface EntityPartialSet {
    public function getClass();
    public function getMinimumValue();
    public function getMaximumValue();
    public function getData();
}
