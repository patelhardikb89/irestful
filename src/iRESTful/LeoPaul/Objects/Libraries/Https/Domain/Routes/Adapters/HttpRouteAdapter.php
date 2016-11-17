<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\Adapters;

interface HttpRouteAdapter {
    public function fromDataToHttpRoute(array $data);
    public function fromDataToHttpRoutes(array $data);
}
