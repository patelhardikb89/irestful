<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters\Adapters;

interface DeleteAdapterAdapter {
    public function fromDataToDeleteAdapter(array $data);
}
