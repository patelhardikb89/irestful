<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters;

interface KeynameAdapter {
    public function fromDataToKeyname(array $data);
}
