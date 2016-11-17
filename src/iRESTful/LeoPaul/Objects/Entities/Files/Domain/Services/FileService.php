<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

interface FileService {
	public function insert(Uuid $futureFileUuid);
	public function delete(File $file);
}
