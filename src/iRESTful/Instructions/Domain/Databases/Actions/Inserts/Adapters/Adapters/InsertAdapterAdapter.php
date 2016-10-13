<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Inserts\Adapters\Adapters;

interface InsertAdapterAdapter {
    public function fromDataToInsertAdapter(array $data);
}
