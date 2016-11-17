<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Inserts\Adapters\Adapters;

interface InsertAdapterAdapter {
    public function fromDataToInsertAdapter(array $data);
}
