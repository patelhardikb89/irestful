<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Factories\MicroDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Adapters\MicroDateTimeAdapter;

final class ConcreteMicroDateTimeFactory implements MicroDateTimeFactory {
	private $microDateTimeAdapter;
	public function __construct(MicroDateTimeAdapter $microDateTimeAdapter) {
		$this->microDateTimeAdapter = $microDateTimeAdapter;
	}

	public function create() {
		$microtime = microtime();
		return $this->microDateTimeAdapter->fromStringToMicroDateTime($microtime);
	}

}
