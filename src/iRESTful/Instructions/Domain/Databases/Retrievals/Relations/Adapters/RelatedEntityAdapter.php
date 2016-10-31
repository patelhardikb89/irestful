<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Relations\Adapters;

interface RelatedEntityAdapter {
    public function fromDataToRelatedEntity(array $data);
}
