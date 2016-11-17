<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain;

interface PDO {
    public function hasRequest();
	public function getRequest();
    public function hasRequests();
	public function getRequests();
	public function getMicroDateTimeClosure();
	public function getServer();
}
