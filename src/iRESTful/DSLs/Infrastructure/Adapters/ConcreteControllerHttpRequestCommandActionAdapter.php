<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Adapters\ActionAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestCommandAction;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Exceptions\ActionException;

final class ConcreteControllerHttpRequestCommandActionAdapter implements ActionAdapter {

    public function __construct() {

    }

    public function fromStringToAction($string) {

        if ($string == 'retrieve') {
            return new ConcreteControllerHttpRequestCommandAction(true, false, false, false);
        }

        if ($string == 'insert') {
            return new ConcreteControllerHttpRequestCommandAction(false, true, false, false);
        }

        if ($string == 'update') {
            return new ConcreteControllerHttpRequestCommandAction(false, false, true, false);
        }

        if ($string == 'delete') {
            return new ConcreteControllerHttpRequestCommandAction(false, false, false, true);
        }

        throw new ActionException('The given action ('.$string.') is invalid.');

    }

}
