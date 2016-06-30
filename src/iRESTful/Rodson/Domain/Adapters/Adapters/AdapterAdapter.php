<?php
namespace iRESTful\Rodson\Domain\Adapters\Adapters;

interface AdapterAdapter {
    public function fromDataToAdapters(array $data);
    public function fromDataToAdapter(array $data);
}
