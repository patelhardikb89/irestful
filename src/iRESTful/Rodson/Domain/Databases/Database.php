<?php
namespace iRESTful\Rodson\Domain\Databases;

interface Database {
    public function hasRelational();
    public function getRelational();
    public function hasRESTAPI();
    public function getRESTAPI();
}
