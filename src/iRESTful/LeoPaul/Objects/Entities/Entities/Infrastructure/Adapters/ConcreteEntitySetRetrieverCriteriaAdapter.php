<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters\KeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class ConcreteEntitySetRetrieverCriteriaAdapter implements EntitySetRetrieverCriteriaAdapter {
    private $uuidAdapter;
    private $keynameAdapter;
    private $orderingAdapter;
    public function __construct(UuidAdapter $uuidAdapter, KeynameAdapter $keynameAdapter, OrderingAdapter $orderingAdapter) {
        $this->uuidAdapter = $uuidAdapter;
        $this->keynameAdapter = $keynameAdapter;
        $this->orderingAdapter = $orderingAdapter;
    }

    public function fromDataToEntitySetRetrieverCriteria(array $data) {
        
        if (!isset($data['container'])) {
            throw new EntitySetException('The container index is mandatory in order to convert the data to an EntityRetrieverCriteria object.');
        }

        try {

            $uuids = null;
            if (isset($data['uuids'])) {
                $uuids = $this->uuidAdapter->fromStringsToUuids($data['uuids']);
            }

            $keyname = null;
            if (isset($data['keyname'])) {
                $keyname = $this->keynameAdapter->fromDataToKeyname($data['keyname']);
            }

            $ordering = null;
            if (isset($data['ordering'])) {
                $ordering = $this->orderingAdapter->fromDataToOrdering($data['ordering']);

            }

            return new ConcreteEntitySetRetrieverCriteria($data['container'], $keyname, $uuids, $ordering);

        } catch (UuidException $exception) {
            throw new EntitySetException('There was an exception while converting strings to Uuid objects.', $exception);
        } catch (KeynameException $exception) {
            throw new EntitySetException('There was an exception while converting data to a keyname object.', $exception);
        } catch (OrderingException $exception) {
            throw new EntitySetException('There was an exception while converting data to an ordering object.', $exception);
        }
    }

}
