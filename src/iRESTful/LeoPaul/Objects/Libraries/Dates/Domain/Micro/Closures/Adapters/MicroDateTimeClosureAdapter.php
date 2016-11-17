<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters;

interface MicroDateTimeClosureAdapter {
	public function fromClosureToMicroDateTimeClosure(\Closure $closure);
}
