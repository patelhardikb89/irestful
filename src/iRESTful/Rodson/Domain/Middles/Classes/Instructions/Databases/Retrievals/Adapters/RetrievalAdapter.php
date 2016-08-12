<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters;

interface RetrievalAdapter {
    public function fromStringToRetrieval($string);
}
