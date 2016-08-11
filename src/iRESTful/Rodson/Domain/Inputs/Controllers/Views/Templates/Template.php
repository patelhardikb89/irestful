<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Views\Templates;

interface Template {
    public function getPath();
    public function getProcessorKeyname();
}
