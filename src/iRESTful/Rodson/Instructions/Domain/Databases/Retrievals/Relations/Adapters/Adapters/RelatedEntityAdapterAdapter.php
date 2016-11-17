<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\Adapters\Adapters;

interface RelatedEntityAdapterAdapter {
    public function fromDataToRelatedEntityAdapter(array $data);
}
