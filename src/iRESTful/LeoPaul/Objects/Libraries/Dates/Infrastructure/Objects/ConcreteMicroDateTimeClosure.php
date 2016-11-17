<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class ConcreteMicroDateTimeClosure implements MicroDateTimeClosure {
	private $closure;
	private $startedOn;
	private $endsOn;
	private $results;
	public function __construct(\Closure $closure, MicroDateTime $startedOn, MicroDateTime $endsOn, $results = null) {

		if (empty($results)) {
			$results = null;
		}

		if (!$startedOn->isBefore($endsOn)) {
			throw new MicroDateTimeClosureException('The startedOn MicroDateTime must be before the endsOn MicroDateTime.');
		}

		$this->closure = $closure;
		$this->startedOn = $startedOn;
		$this->endsOn = $endsOn;
		$this->results = $results;
	}

	public function getClosure() {
		return $this->closure;
	}

	public function startedOn() {
		return $this->startedOn;
	}

	public function endsOn() {
		return $this->endsOn;
	}

	public function hasResults() {
		return !empty($this->results);
	}

	public function getResults() {
		return $this->results;
	}

}
