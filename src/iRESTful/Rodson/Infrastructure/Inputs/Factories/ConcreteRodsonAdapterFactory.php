<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Factories;
use iRESTful\Rodson\Domain\Inputs\Adapters\Factories\RodsonAdapterFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRodsonAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteAuthorAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteUrlAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteAuthorEmailAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteProjectAdapterVirgin;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteNameAdapter;

final class ConcreteRodsonAdapterFactory implements RodsonAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $nameAdapter = new ConcreteNameAdapter();

        $urlAdapter = new ConcreteUrlAdapter();
        $authorEmailAdapter = new ConcreteAuthorEmailAdapter();
        $authorAdapter = new ConcreteAuthorAdapter($urlAdapter, $authorEmailAdapter);

        $projectAdapter = new ConcreteProjectAdapterVirgin();
        return new ConcreteRodsonAdapter($nameAdapter, $authorAdapter, $urlAdapter, $projectAdapter);
    }

}
