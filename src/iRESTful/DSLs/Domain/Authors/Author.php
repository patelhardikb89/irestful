<?php
namespace iRESTful\DSLs\Domain\Authors;

interface Author {
    public function getName();
    public function getEmail();
    public function hasUrl();
    public function getUrl();
}
