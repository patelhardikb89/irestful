<?php
namespace  iRESTful\Rodson\Outputs\Domain\Codes\Paths\Adapters;

interface PathAdapter {
    public function fromRelativePathStringToPath($relativePath);
}
