<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions;

interface Conversion {
    public function from();
    public function to();
    public function getData();
}
