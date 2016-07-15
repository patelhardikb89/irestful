<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters;

interface PathAdapter {
    public function fromRelativePathStringToPath($relativePath);
}
