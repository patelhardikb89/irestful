<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Adapters;

interface PathAdapter {
	public function fromContentToPath($content);
	public function fromRelativePathStringToPath($path);
}
