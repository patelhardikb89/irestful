<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class ConcretePDO implements PDO {
	private $request;
	private $microDateTimeClosure;
	private $server;
	public function __construct(MicroDateTimeClosure $microDateTimeClosure, Server $server, Request $request = null, array $requests = null) {

        if (empty($requests)) {
            $requests = null;
        }

        $amount = (empty($request) ? 0 : 1) + (empty($requests) ? 0 : 1);
        if ($amount != 1) {
            throw new PDOException('Either a request or requests must be provided.  '.$amount.' of them have been provided.');
        }

		$this->request = $request;
        $this->requests = $requests;
		$this->microDateTimeClosure = $microDateTimeClosure;
		$this->server = $server;
	}

    public function hasRequest() {
        return !empty($this->request);
    }

	public function getRequest() {
		return $this->request;
	}

    public function hasRequests() {
        return !empty($this->requests);
    }

	public function getRequests() {
        return $this->requests;
    }

	public function getMicroDateTimeClosure() {
		return $this->microDateTimeClosure;
	}

	public function getServer() {
		return $this->server;
	}



}
