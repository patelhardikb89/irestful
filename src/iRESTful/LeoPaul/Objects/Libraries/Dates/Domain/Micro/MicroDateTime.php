<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro;

interface MicroDateTime {
	public function getDateTime();
	public function getMicroSeconds();
	public function isBefore(MicroDateTime $microDateTime);
}
