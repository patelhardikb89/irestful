<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Adapters\Adapters;

interface DeleteAdapterAdapter {
    public function fromDataToDeleteAdapter(array $data);
}
