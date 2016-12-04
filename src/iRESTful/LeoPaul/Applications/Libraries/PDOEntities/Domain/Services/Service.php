<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services;

interface Service {
    public function getRepository();
    public function getService();
    public function getAdapter();
}
