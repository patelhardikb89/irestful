<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;

final class ConcreteEntityPartialSetRetrieverCriteriaAdapter implements EntityPartialSetRetrieverCriteriaAdapter {
    private $orderingAdapter;
    public function __construct(OrderingAdapter $orderingAdapter) {
        $this->orderingAdapter = $orderingAdapter;
    }

    public function fromDataToEntityPartialSetRetrieverCriteria(array $data) {
        if (!isset($data['container'])) {
            throw new EntityPartialSetException('The container keyname is mandatory in order to convert the data to an EntitySetRetrieverCriteria object.');
        }

        if (!isset($data['index'])) {
            throw new EntityPartialSetException('The index keyname is mandatory in order to convert the data to an EntitySetRetrieverCriteria object.');
        }

        if (!isset($data['amount'])) {
            throw new EntityPartialSetException('The amount keyname is mandatory in order to convert the data to an EntitySetRetrieverCriteria object.');
        }

        try {

            $ordering = null;
            if (isset($data['ordering'])) {
                $ordering = $this->orderingAdapter->fromDataToOrdering($data['ordering']);
            }

            $index = (integer) $data['index'];
            $amount = (integer) $data['amount'];

            return new ConcreteEntityPartialSetRetrieverCriteria($data['container'], $index, $amount, $ordering);

        } catch (OrderingException $exception) {
            throw new EntityPartialSetException('There was an exception while converting data to an Ordering object.', $exception);
        }
    }

}
