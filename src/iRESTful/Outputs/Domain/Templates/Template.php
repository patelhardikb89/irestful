<?php
namespace  iRESTful\Outputs\Domain\Templates;

interface Template {
    public function render($file, array $data);
}
