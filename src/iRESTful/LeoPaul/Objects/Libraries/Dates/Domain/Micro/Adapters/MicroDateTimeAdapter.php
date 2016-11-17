<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;

interface MicroDateTimeAdapter {
	public function fromStringToMicroDateTime($microTime);
	public function fromMicroDateTimeToData(MicroDateTime $microDateTime);
	public function fromDataToMicroDateTime(array $data);
}
