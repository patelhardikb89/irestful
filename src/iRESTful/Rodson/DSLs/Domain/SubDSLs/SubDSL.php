<?php
namespace iRESTful\Rodson\DSLs\Domain\SubDSLs;

interface SubDSL {
    public function getName();
    public function getDatabase();
    public function getDSL();
}
