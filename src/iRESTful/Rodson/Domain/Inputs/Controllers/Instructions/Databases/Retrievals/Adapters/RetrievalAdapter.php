<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\Adapters;

interface RetrievalAdapter {
    public function fromStringToRetrieval($string);
}
