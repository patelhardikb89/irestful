<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals;

interface Retrieval {
    public function hasHttpRequest();
    public function getHttpRequest();
    public function hasEntity();
    public function getEntity();
    public function hasMultipleEntities();
    public function getMultipleEntities();
    public function hasEntityPartialSet();
    public function getEntityPartialSet();
}
