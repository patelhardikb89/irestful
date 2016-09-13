<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Views\Adapters\ViewAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Views\Exceptions\ViewException;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteControllerHttpRequestView;

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
