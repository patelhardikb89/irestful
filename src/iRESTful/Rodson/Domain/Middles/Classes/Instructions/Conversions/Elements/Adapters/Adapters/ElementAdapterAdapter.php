<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Adapters\Adapters;

interface ElementAdapterAdapter {
    public function fromDataToElementAdapter(array $data);
}
