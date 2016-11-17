<?php
namespace iRESTful\Rodson\DSLs\Domain;

interface DSL {
    public function getName();
    public function getType();
    public function getUrl();
    public function getLicense();
    public function getAuthors();
    public function getProject();
}
