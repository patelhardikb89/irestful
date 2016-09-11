<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;

interface CodeAdapter {
    public function fromClassesToCode(array $classes);
}
