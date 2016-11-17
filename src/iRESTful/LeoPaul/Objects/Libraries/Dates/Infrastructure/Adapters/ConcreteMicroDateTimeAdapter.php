<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Adapters\MicroDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Objects\ConcreteMicroDateTime;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;

final class ConcreteMicroDateTimeAdapter implements MicroDateTimeAdapter {
	private $dateTimeAdapter;
	public function __construct(DateTimeAdapter $dateTimeAdapter) {
		$this->dateTimeAdapter = $dateTimeAdapter;
	}

	public function fromStringToMicroDateTime($microTime) {

		$exploded = explode(' ', $microTime);
		if (count($exploded) != 2) {
			throw new MicroDateTimeException('The format of the microTime string must be: sec msec, where sec is the amount of seconds in unix timestamp and msec is the amount of milliseconds since the seconds, in seconds.');
		}

		try {

			$dateTime = $this->dateTimeAdapter->fromTimestampToDateTime($exploded[1]);
			$microSeconds = (int) bcmul($exploded[0], (string) 1000000);
			return new ConcreteMicroDateTime($dateTime, $microSeconds);

		} catch (DateTimeException $exception) {
			throw new MicroDateTimeException('There was an exception while converting a timestamp to a DateTime object.', $exception);
		}

	}

	public function fromMicroDateTimeToData(MicroDateTime $microDateTime) {

		$timestamp = $microDateTime->getDateTime()->getTimestamp();
		$microSeconds = $microDateTime->getMicroSeconds();

		return [
			'timestamp' => $timestamp,
			'micro_seconds' => $microSeconds
		];

	}

	public function fromDataToMicroDateTime(array $data) {

		if (!isset($data['timestamp'])) {
			throw new MicroDateTimeException('The timestamp is mandatory in order to convert data to a MicroDateTime object.');
		}

		$microSeconds = 0;
		if (isset($data['micro_seconds'])) {
			$microSeconds = (int) $data['micro_seconds'];
		}

		try {

			$dateTime = $this->dateTimeAdapter->fromTimestampToDateTime($data['timestamp']);
			return new ConcreteMicroDateTime($dateTime, $microSeconds);

		} catch (DateTimeException $exception) {
			throw new MicroDateTimeException('There was an exception while converting a timestamp to a DateTime object.', $exception);
		}

	}

}
