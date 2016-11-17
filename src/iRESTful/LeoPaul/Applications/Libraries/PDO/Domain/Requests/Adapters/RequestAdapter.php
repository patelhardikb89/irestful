<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;

interface RequestAdapter {
	public function fromDataToRequest(array $data);
    public function fromDataToRequests(array $data);
	public function fromRequestToData(Request $request);
}
