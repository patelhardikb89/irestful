<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets;

interface EntityPartialSet {
    public function getAnnotatedClass();
    public function getIndexValue();
    public function getAmountValue();
    public function getData();
}
