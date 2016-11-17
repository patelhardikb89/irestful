<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\Factories\EntitySetRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;

final class ConcreteEntitySetRetrieverCriteriaAdapterFactory implements EntitySetRetrieverCriteriaAdapterFactory {

    public function __construct() {

    }

    public function create() {
        $uuidAdapter = new ConcreteUuidAdapter();
        $keynameAdapter = new ConcreteKeynameAdapter();
        $orderingAdapter = new ConcreteOrderingAdapter();
        return new ConcreteEntitySetRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter, $orderingAdapter);
    }

}
