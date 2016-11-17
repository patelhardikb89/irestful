<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\Factories\EntityRelationRetrieverCriteriaAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;

final class ConcreteEntityRelationRetrieverCriteriaAdapterFactory implements EntityRelationRetrieverCriteriaAdapterFactory {

    public function __construct() {

    }

    public function create() {
        $uuidAdapter = new ConcreteUuidAdapter();
        return new ConcreteEntityRelationRetrieverCriteriaAdapter($uuidAdapter);
    }

}
