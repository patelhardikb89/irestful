<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Adapters\CommandAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Exceptions\CommandException;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Adapters\ActionAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Adapters\UrlAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestCommand;

final class ConcreteControllerHttpRequestCommandAdapter implements CommandAdapter {
    private $actionAdapter;
    private $urlAdapter;
    public function __construct(ActionAdapter $actionAdapter, UrlAdapter $urlAdapter) {
        $this->actionAdapter = $actionAdapter;
        $this->urlAdapter = $urlAdapter;
    }

    public function fromStringToCommand($string) {

        $exploded = explode(' ', $string);
        if (count($exploded) != 2) {
            throw new CommandException('The given command ('.$string.') is invalid.');
        }

        $action = $this->actionAdapter->fromStringToAction(trim($exploded[0]));
        $url = $this->urlAdapter->fromStringToUrl(trim($exploded[1]));
        return new ConcreteControllerHttpRequestCommand($action, $url);
    }

}
