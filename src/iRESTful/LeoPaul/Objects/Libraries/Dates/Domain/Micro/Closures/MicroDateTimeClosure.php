<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures;

interface MicroDateTimeClosure {
	public function getClosure();
	public function startedOn();
	public function endsOn();
	public function hasResults();
	public function getResults();
}
