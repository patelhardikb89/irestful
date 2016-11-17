<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Views\Adapters\ViewAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Views\Exceptions\ViewException;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteControllerHttpRequestView;

final class ConcreteControllerHttpRequestViewAdapter implements ViewAdapter {

    public function __construct() {

    }

    public function fromStringToView($string) {

        $string = strtolower($string);
        if ($string == 'json') {
            return new ConcreteControllerHttpRequestView(true);
        }

        throw new ViewException('The given string () is not a valid View.');

    }

}
