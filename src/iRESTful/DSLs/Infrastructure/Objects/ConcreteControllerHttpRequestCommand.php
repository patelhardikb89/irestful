<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Command;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Action;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Url;

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
