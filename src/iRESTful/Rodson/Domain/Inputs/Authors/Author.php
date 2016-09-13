<?php
namespace iRESTful\Rodson\Domain\Inputs\Authors;

interface Author {
    public function getName();
    public function getEmail();
    public function hasUrl();
    public function getUrl();
    public function getData();
}
