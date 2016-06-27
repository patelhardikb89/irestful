<?php
namespace iRESTful\Rodson\Domain\Adapters;

interface Adapter {
    public function getFromType();
    public function getToType();
    public function getCode();
}
