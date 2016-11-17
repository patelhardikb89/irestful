<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Factories\DateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter;

final class ConcreteDateTimeFactory implements DateTimeFactory {
	private $adapter;
	public function __construct(DateTimeAdapter $adapter) {
		$this->adapter = $adapter;
	}

	public function create() {
		$timestamp = time();
		return $this->adapter->fromTimestampToDateTime($timestamp);
	}

}
