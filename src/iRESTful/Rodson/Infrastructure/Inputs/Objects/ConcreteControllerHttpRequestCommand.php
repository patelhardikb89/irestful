<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Command;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Actions\Action;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Url;

final class ConcreteControllerHttpRequestCommand implements Command {
    private $action;
    private $url;
    public function __construct(Action $action, Url $url) {
        $this->action = $action;
        $this->url = $url;
    }

    public function getAction() {
        return $this->action;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getData() {
        return [
            'action' => $this->action->getData(),
            'url' => $this->url->getData()
        ];
    }

}
