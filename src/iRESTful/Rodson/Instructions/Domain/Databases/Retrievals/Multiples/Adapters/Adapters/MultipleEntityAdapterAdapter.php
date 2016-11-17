<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\Adapters;

interface MultipleEntityAdapterAdapter {
    public function fromDataToMultipleEntityAdapter(array $data);
}
