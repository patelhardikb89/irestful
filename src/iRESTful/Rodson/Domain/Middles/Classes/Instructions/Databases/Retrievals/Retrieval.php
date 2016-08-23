<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals;

interface Retrieval {
    public function hasHttpRequest();
    public function getHttpRequest();
    public function hasEntity();
    public function getEntity();
    public function hasMultipleEntities();
    public function getMultipleEntities();
    public function hasEntityPartialSet();
    public function getEntityPartialSet();
    public function getData();
}
