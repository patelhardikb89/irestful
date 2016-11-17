<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;

interface ResponseAdapter {
    public function fromHttpResponseToData(HttpResponse $httpResponse);
}
