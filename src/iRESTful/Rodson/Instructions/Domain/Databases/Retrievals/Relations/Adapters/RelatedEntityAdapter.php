<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\Adapters;

interface RelatedEntityAdapter {
    public function fromDataToRelatedEntity(array $data);
}
