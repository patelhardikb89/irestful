<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Command;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Actions\Action;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Urls\Url;

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

}
