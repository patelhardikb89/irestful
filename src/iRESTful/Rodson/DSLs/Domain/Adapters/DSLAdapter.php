<?php
namespace iRESTful\Rodson\DSLs\Domain\Adapters;

interface DSLAdapter {
    public function fromDataToDSL(array $data);
}
