<?php
namespace iRESTful\DSLs\Infrastructure\Factories;
use iRESTful\DSLs\Domain\Adapters\Factories\DSLAdapterFactory;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDSLAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteAuthorAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteUrlAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteAuthorEmailAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteProjectAdapterVirgin;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteNameAdapter;

final class ConcreteDSLAdapterFactory implements DSLAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $nameAdapter = new ConcreteNameAdapter();

        $urlAdapter = new ConcreteUrlAdapter();
        $authorEmailAdapter = new ConcreteAuthorEmailAdapter();
        $authorAdapter = new ConcreteAuthorAdapter($urlAdapter, $authorEmailAdapter);

        $projectAdapter = new ConcreteProjectAdapterVirgin();
        return new ConcreteDSLAdapter($nameAdapter, $authorAdapter, $urlAdapter, $projectAdapter);
    }

}
