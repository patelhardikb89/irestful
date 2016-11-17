<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Adapters\Adapters;

interface RetrievalAdapterAdapter {
    public function fromDataToRetrievalAdapter(array $data);
}
