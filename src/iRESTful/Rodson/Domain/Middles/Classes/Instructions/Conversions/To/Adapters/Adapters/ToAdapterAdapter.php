<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\Adapters;

interface ToAdapterAdapter {
    public function fromDataToToAdapter(array $data);
}
