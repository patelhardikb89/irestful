<?php
namespace iRESTful\Rodson\Instructions\Domain\Values\Loops\Adapters;

interface LoopAdapter {
    public function fromStringToLoop($string);
}
