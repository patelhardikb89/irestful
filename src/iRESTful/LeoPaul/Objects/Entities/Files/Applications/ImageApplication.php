<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Applications;

interface ImageApplication {
	public function convert(array $input);
	public function resize(array $input);
	public function delete(array $input);
}
