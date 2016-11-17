<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteRequest;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Exceptions\RequestException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;

final class ConcreteRequestAdapter implements RequestAdapter {

	private $cache;
	public function __construct() {
		$this->cache = [];
	}

	public function fromDataToRequest(array $data) {

		$key = md5(serialize($data));
		if (isset($this->cache[$key])) {
			return $this->cache[$key];
		}

		if (!isset($data['query'])) {
			throw new RequestException('The query keyname is mandatory in order to convert data to a Request object.');
		}

		$params = (isset($data['params']) && is_array($data['params'])) ? $data['params'] : null;
		$this->cache[$key] = new ConcreteRequest($data['query'], $params);
		return $this->cache[$key];
	}

    public function fromDataToRequests(array $data) {

        $requests = [];
        foreach($data as $oneData) {
            $requests[] = $this->fromDataToRequest($oneData);
        }

        return $requests;

    }

    public function fromRequestToData(Request $request) {

		$output = [
			'query' => $request->getQuery()
		];

		if ($request->hasParams()) {
			$output['params'] = $request->getParams();
		}

		return $output;

	}

}
