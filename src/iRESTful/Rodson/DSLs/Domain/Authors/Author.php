<?php
namespace iRESTful\Rodson\DSLs\Domain\Authors;

interface Author {
    public function getName();
    public function getEmail();
    public function hasUrl();
    public function getUrl();
}
