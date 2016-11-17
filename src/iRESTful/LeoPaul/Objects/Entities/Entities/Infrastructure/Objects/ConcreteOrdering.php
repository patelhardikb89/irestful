<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;

final class ConcreteOrdering implements Ordering {
	private $names;
	private $isAscending;
	public function __construct(array $names, $isAscending) {

		if (empty($names)) {
			throw new OrderingException('The names must contain at least 1 element.  None given.');
		}

        foreach($names as $oneName) {
            if (!is_string($oneName)) {
                throw new OrderingException('The names must be strings.  At least one of the elements in the names array is not a string.');
            }
        }

		$this->names = $names;
		$this->isAscending = (bool) $isAscending;
	}

	public function getNames() {
		return $this->names;
	}

	public function isAscending() {
		return $this->isAscending;
	}

}
