<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Inputs;

interface Input {
    public function hasType();
    public function getType();
    public function hasObject();
    public function getObject();
}
