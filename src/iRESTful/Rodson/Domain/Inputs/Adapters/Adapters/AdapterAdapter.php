<?php
namespace iRESTful\Rodson\Domain\Inputs\Adapters\Adapters;

interface AdapterAdapter {
    public function fromDataToAdapters(array $data);
    public function fromDataToAdapter(array $data);
}
