<?php
namespace iRESTful\Rodson\Applications\Domain\Domains;

interface Domain {
    public function getObjects();
    public function getEntities();
    public function getValues();
}
