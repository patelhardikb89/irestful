<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Factories;
use iRESTful\Rodson\DSLs\Domain\Adapters\Factories\DSLAdapterFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDSLAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteAuthorAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteUrlAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteAuthorEmailAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteProjectAdapterVirgin;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteNameAdapter;

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
