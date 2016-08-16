<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Adapters\Adapters;

interface InsertAdapterAdapter {
    public function fromDataToInsertAdapter(array $data);
}
