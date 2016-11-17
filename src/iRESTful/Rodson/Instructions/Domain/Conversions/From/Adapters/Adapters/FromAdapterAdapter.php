<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\From\Adapters\Adapters;

interface FromAdapterAdapter {
    public function fromDataToFromAdapter(array $data);
}
