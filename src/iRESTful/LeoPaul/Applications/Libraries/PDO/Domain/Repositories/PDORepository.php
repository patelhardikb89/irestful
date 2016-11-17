<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories;

interface PDORepository {
	public function fetch(array $request);
	public function fetchFirst(array $request);
}
