<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions;

interface Conversion {
    public function hasFrom();
    public function getFrom();
    public function hasTo();
    public function getTo();
    public function hasConverter();
    public function getConverter();
}
