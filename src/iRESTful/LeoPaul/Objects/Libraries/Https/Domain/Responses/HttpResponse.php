<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses;

interface HttpResponse {
    public function getCode();
    public function getContent();
    public function hasHeaders();
    public function getHeaders();
}
