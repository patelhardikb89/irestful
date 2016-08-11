<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Adapters\Adapters\HttpRequestAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Adapters\CommandAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Views\Adapters\ViewAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerHttpRequestAdapter;

final class ConcreteControllerHttpRequestAdapterAdapter implements HttpRequestAdapterAdapter {
    private $commandAdapter;
    private $viewAdapter;
    private $valueAdapterAdapter;
    public function __construct(CommandAdapter $commandAdapter, ViewAdapter $viewAdapter, ValueAdapterAdapter $valueAdapterAdapter) {
        $this->commandAdapter = $commandAdapter;
        $this->viewAdapter = $viewAdapter;
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToHttpRequestAdapter(array $data) {
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter($data);
        return new ConcreteControllerHttpRequestAdapter($this->commandAdapter, $this->viewAdapter, $valueAdapter);
    }

}
