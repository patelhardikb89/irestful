<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\Factories\EntityPartialSetRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;

final class ConcreteEntityPartialSetRetrieverCriteriaAdapterFactory implements EntityPartialSetRetrieverCriteriaAdapterFactory {

    public function __construct() {

    }

    public function create() {
        $orderingAdapter = new ConcreteOrderingAdapter();
        return new ConcreteEntityPartialSetRetrieverCriteriaAdapter($orderingAdapter);
    }

}
