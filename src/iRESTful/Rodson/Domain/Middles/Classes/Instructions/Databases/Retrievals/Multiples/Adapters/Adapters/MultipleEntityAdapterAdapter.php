<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\Adapters;

interface MultipleEntityAdapterAdapter {
    public function fromDataToMultipleEntityAdapter(array $data);
}
