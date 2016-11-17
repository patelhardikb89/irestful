<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes;

interface HttpRoute {
    public function getMethod();
    public function getEndpoint();
    public function getClassName();
}
