<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Factories\MicroDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Objects\ConcreteMicroDateTimeClosure;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;

final class ConcreteMicroDateTimeClosureAdapter implements MicroDateTimeClosureAdapter {
	private $microDateTimeFactory;
	public function __construct(MicroDateTimeFactory $microDateTimeFactory) {
		$this->microDateTimeFactory = $microDateTimeFactory;
	}

	public function fromClosureToMicroDateTimeClosure(\Closure $closure) {

		try {

			$startedOn = $this->microDateTimeFactory->create();
			$results = $closure();
			$endsOn = $this->microDateTimeFactory->create();
			return new ConcreteMicroDateTimeClosure($closure, $startedOn, $endsOn, $results);

		} catch (MicroDateTimeException $exception) {
			throw new MicroDateTimeClosureException('There was an exception while creating a MicroDateTime object.', $exception);
		} catch (\Exception $exception) {
			throw new MicroDateTimeClosureException('There was an exception while executing the closure.', $exception);
		}

	}

}
