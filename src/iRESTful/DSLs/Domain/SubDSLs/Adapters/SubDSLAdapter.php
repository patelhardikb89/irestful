<?php
namespace iRESTful\DSLs\Domain\SubDSLs\Adapters;

interface SubDSLAdapter {
    public function fromDataToSubDSLs(array $data);
    public function fromDataToSubDSL(array $data);
}
