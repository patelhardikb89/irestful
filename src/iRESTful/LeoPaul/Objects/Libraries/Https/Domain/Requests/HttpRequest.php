<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests;

interface HttpRequest {
    public function process($uriPattern);
    public function getURI();
    public function getMethod();
    public function getPort();
    public function hasQueryParameters();
    public function getQueryParameters();
    public function hasRequestParameters();
    public function getRequestParameters();
    public function hasParameters();
    public function getParameters();
    public function hasHeaders();
    public function getHeaders();
    public function hasFilePath();
    public function getFilePath();
}
