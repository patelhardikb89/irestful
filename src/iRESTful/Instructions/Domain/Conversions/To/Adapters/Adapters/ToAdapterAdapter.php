<?php
namespace iRESTful\Instructions\Domain\Conversions\To\Adapters\Adapters;

interface ToAdapterAdapter {
    public function fromDataToToAdapter(array $data);
}
