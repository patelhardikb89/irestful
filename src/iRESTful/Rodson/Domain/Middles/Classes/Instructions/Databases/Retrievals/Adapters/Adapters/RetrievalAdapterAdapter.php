<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters\Adapters;

interface RetrievalAdapterAdapter {
    public function fromDataToRetrievalAdapter(array $data);
}
