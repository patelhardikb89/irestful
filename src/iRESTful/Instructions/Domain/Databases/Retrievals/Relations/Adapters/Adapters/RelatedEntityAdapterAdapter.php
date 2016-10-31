<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Relations\Adapters\Adapters;

interface RelatedEntityAdapterAdapter {
    public function fromDataToRelatedEntityAdapter(array $data);
}
