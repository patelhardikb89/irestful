<?php
namespace iRESTful\DSLs\Domain\Projects\Databases\Relationals;

interface RelationalDatabase {
    public function getDriver();
    public function getHostName();
    public function getEngine();
    public function hasCredentials();
    public function getCredentials();
}
