<?php
namespace iRESTful\Rodson\Domain\Outputs\Templates;

interface Template {
    public function render($file, array $data);
}
