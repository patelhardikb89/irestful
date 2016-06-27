<?php
namespace iRESTful\Rodson\Domain\Databases\RESTAPIs;

interface RESTAPI {
    public function hasCredentials();
    public function getCredentials();
    public function hasToken();
    public function getToken();
    public function getBaseUrl();
    public function getPort();
}
