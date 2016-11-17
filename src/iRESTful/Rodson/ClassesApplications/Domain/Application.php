<?php
namespace iRESTful\Rodson\ClassesApplications\Domain;

interface Application {
    public function getNamespace();
    public function getConfiguration();
}
