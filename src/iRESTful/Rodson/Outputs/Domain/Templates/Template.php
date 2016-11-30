<?php
namespace  iRESTful\Rodson\Outputs\Domain\Templates;

interface Template {
    public function render($file, array $data = null);
}
