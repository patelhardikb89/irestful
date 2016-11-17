<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Exceptions\RequestException;

final class ConcreteRequest implements Request {

	public function __construct($query, array $params = null) {

		$addSemiColonToKeynames = function(array $params = null) {

			if (empty($params)) {
				return null;
			}

			$output = [];
	        foreach($params as $keyname => $value) {

				if (strpos($keyname, ':') !== 0) {
					$keyname = ':'.$keyname;
				}

	            $output[$keyname] = $value;
	        }

	        return $output;

		};

		if (!is_string($query) || empty($query)) {
			throw new RequestException('The query must be a non-empty string.');
		}

		$this->query = $query;
		$this->params = $addSemiColonToKeynames($params);

	}

	public function getQuery() {
		return $this->query;
	}

	public function hasParams() {
		return !empty($this->params);
	}

	public function getParams() {
		return $this->params;
	}

}
