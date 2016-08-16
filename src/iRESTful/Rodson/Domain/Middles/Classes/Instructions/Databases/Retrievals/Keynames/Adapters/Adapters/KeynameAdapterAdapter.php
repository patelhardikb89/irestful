<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\Adapters;

interface KeynameAdapterAdapter {
    public function fromDataToKeynameAdapter(array $data);
}
