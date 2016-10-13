<?php
namespace iRESTful\DSLs\Domain\Adapters;

interface DSLAdapter {
    public function fromDataToDSL(array $data);
}
