<?php
namespace iRESTful\Rodson\Domain\Middles\Applications;

interface Application {
    public function getNamespace();
    public function getConfiguration();
    public function getData();
}
