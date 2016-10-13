<?php
namespace iRESTful\ClassesApplications\Domain;

interface Application {
    public function getNamespace();
    public function getConfiguration();
}
