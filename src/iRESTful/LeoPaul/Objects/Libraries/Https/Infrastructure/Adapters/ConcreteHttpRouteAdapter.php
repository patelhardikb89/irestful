<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\Adapters\HttpRouteAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects\ConcreteHttpRoute;

final class ConcreteHttpRouteAdapter implements HttpRouteAdapter {

    public function __construct() {

    }

    public function fromDataToHttpRoute(array $data) {

        if (!isset($data['method'])) {
            throw new HttpException('The method keyname is mandatory in order to convert data to HttpRoute objects.');
        }

        if (!isset($data['endpoint'])) {
            throw new HttpException('The endpoint keyname is mandatory in order to convert data to HttpRoute objects.');
        }

        if (!isset($data['class'])) {
            throw new HttpException('The class keyname is mandatory in order to convert data to HttpRoute objects.');
        }

        return new ConcreteHttpRoute($data['method'], $data['endpoint'], $data['class']);

    }

    public function fromDataToHttpRoutes(array $data) {
        $output = array();
        foreach($data as $oneData) {
            $output[] = $this->fromDataToHttpRoute($oneData);
        }

        return $output;
    }

}
