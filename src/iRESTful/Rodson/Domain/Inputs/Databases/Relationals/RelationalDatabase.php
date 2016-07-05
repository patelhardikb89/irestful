<?php
namespace iRESTful\Rodson\Domain\Inputs\Databases\Relationals;

interface RelationalDatabase {
    public function getDriver();
    public function getHostName();
    public function hasCredentials();
    public function getCredentials();
}
