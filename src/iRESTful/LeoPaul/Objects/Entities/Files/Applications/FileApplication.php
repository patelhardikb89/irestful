<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Applications;

interface FileApplication {
	public function upload(array $input);
	public function delete(array $input);
}
