<?php
namespace iRESTful\DSLs\Domain\Names\Adapters;

interface NameAdapter {
    public function fromStringToName($string);
}
