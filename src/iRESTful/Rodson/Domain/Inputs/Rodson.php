<?php
namespace iRESTful\Rodson\Domain\Inputs;

interface Rodson {
    public function getName();
    public function getType();
    public function getUrl();
    public function getLicense();
    public function getAuthors();
    public function getProject();
}
