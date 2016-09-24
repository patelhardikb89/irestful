<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Databases\RESTAPIs;

interface RESTAPI {
    public function hasCredentials();
    public function getCredentials();
    public function hasHeaderLine();
    public function getHeaderLine();
    public function getBaseUrl();
    public function getPort();
    public function getData();
}
