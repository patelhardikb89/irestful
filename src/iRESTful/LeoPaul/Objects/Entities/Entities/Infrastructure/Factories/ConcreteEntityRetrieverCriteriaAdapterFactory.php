<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\Factories\EntityRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteKeynameAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;

final class ConcreteEntityRetrieverCriteriaAdapterFactory implements EntityRetrieverCriteriaAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $uuidAdapter = new ConcreteUuidAdapter();
        $keynameAdapter = new ConcreteKeynameAdapter();
        return new ConcreteEntityRetrieverCriteriaAdapter($uuidAdapter, $keynameAdapter);

    }

}
