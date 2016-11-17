<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteOrdering;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

final class ConcreteOrderingAdapter implements OrderingAdapter {

	public function __construct() {

	}

	public function fromDataToOrdering(array $data) {

        if (isset($data['names']) && isset($data['name'])) {
            throw new OrderingException('The names or name keyname is mandatory in order to convert data to an Ordering object.');
        }

		$names = [];
		if (isset($data['names'])) {
			$names = $data['names'];
		}

		if (isset($data['name'])) {
			$names[] = $data['name'];
		}

		$isAscending = true;
		if (isset($data['is_ascending'])) {
			$isAscending = (bool) $data['is_ascending'];
		}

		return new ConcreteOrdering($names, $isAscending);

	}

    public function fromOrderingToData(Ordering $ordering) {

        return [
            'names' => $ordering->getNames(),
            'is_ascending' => $ordering->isAscending()
        ];

    }

}
