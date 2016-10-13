<?php
namespace  iRESTful\Outputs\Domain\Codes\Paths\Adapters;

interface PathAdapter {
    public function fromRelativePathStringToPath($relativePath);
}
