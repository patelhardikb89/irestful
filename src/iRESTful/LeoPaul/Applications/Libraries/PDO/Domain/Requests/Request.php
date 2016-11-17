<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests;

interface Request {
	public function getQuery();
	public function hasParams();
	public function getParams();
}
