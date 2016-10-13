<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\Adapters;

interface KeynameAdapterAdapter {
    public function fromDataToKeynameAdapter(array $data);
}
