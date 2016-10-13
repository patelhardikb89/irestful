<?php
namespace iRESTful\Instructions\Domain\Values\Loops\Keynames\Adapters;

interface KeynameAdapter {
    public function fromStringToKeyname($string);
}
