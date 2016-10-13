<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Keynames\Adapters;

interface KeynameAdapter {
    public function fromDataToKeyname(array $data);
}
