<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

interface OrderingAdapter {
	public function fromDataToOrdering(array $data);
    public function fromOrderingToData(Ordering $ordering);
}
