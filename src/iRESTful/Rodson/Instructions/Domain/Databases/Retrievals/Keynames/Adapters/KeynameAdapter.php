<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Keynames\Adapters;

interface KeynameAdapter {
    public function fromDataToKeyname(array $data);
}
