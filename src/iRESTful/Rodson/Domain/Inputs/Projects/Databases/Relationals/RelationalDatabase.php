<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals;

interface RelationalDatabase {
    public function getDriver();
    public function getHostName();
    public function hasCredentials();
    public function getCredentials();
}