<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters;

interface KeynameAdapter {
    public function fromDataToKeyname(array $data);
    public function fromDataToKeynames(array $data);
}
