<?php
namespace iRESTful\Instructions\Domain\Conversions\From\Adapters\Adapters;

interface FromAdapterAdapter {
    public function fromDataToFromAdapter(array $data);
}
