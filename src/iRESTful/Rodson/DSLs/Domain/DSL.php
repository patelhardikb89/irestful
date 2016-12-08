<?php
namespace iRESTful\Rodson\DSLs\Domain;

interface DSL {
    public function getName();
    public function getType();
    public function getUrls();
    public function getLicense();
    public function getAuthors();
    public function getMaintainer();
    public function getProject();
    public function getVersion();
}
