<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services;

interface PDOService {
	public function query(array $request);
    public function queries(array $requests);
}
