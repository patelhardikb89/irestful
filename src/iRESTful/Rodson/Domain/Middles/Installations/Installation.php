<?php
namespace iRESTful\Rodson\Domain\Middles\Installations;

interface Installation {
    public function getNamespace();
    public function getObjectConfiguration();
    public function getRelationalDatabase();
    public function getData();
}
