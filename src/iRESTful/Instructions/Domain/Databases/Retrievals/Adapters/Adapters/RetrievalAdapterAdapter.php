<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Adapters\Adapters;

interface RetrievalAdapterAdapter {
    public function fromDataToRetrievalAdapter(array $data);
}
