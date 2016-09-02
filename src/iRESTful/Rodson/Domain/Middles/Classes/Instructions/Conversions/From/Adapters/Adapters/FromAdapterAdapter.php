<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Adapters\Adapters;

interface FromAdapterAdapter {
    public function fromDataToFromAdapter(array $data);
}
