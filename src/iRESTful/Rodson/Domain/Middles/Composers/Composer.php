<?php
namespace iRESTful\Rodson\Domain\Middles\Composers;

interface Composer {
    public function getName();
    public function getType();
    public function getHomepage();
    public function getLicense();
    public function getAuthors();
    public function getBaseNamespace();
    public function getBaseFolder();
    public function getData();
}
