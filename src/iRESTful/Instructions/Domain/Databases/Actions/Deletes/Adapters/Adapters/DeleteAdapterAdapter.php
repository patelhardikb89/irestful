<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Deletes\Adapters\Adapters;

interface DeleteAdapterAdapter {
    public function fromDataToDeleteAdapter(array $data);
}
