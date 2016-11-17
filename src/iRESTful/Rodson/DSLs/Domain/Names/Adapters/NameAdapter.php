<?php
namespace iRESTful\Rodson\DSLs\Domain\Names\Adapters;

interface NameAdapter {
    public function fromStringToName($string);
}
