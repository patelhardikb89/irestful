<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\To\Adapters\Adapters;

interface ToAdapterAdapter {
    public function fromDataToToAdapter(array $data);
}
