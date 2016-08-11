<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\Keynames\Adapters;

interface KeynameAdapter {
    public function fromDataToKeyname(array $data);
}
