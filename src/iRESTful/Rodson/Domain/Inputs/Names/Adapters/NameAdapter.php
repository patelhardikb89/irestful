<?php
namespace iRESTful\Rodson\Domain\Inputs\Names\Adapters;

interface NameAdapter {
    public function fromStringToName($string);
}
