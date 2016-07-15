<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Adapters;

interface FileAdapter {
    public function fromFileStringToFile($file);
}
