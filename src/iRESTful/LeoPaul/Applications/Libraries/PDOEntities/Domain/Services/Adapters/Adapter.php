<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Adapters;

interface Adapter {
    public function getEntity();
    public function getEntityPartialSet();
    public function getObject();
}
