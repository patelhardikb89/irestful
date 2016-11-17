<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;

final class ConcreteMicroDateTime implements MicroDateTime {
	private $dateTime;
	private $microSeconds;
	public function __construct(\DateTime $dateTime, $microSeconds) {

		if (!is_int($microSeconds)) {
			throw new MicroDateTimeException('The microSeconds parameter must be an integer.');
		}

		$this->dateTime = $dateTime;
		$this->microSeconds = $microSeconds;

	}

	public function getDateTime() {
		return $this->dateTime;
	}

	public function getMicroSeconds() {
		return $this->microSeconds;
	}

	public function isBefore(MicroDateTime $microDateTime) {

		$fromTimestamp = $this->dateTime->getTimestamp();
		$toTimestamp = $microDateTime->getDateTime()->getTimestamp();

		if ($fromTimestamp < $toTimestamp) {
			return true;
		}

		$fromMicroSeconds = $this->microSeconds;
		$toMicroSeconds = $microDateTime->getMicroSeconds();

		if ($fromMicroSeconds < $toMicroSeconds) {
			return true;
		}

		return false;

	}

}
