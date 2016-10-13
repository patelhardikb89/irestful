<?php
namespace iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Adapters;

interface PropertyAdapter {
    public function fromStringToProperty($string);
}
