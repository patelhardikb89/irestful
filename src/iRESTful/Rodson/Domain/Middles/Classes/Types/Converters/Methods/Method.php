<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Methods;

interface Method {
    public function getName();
    public function getParameter();
    public function getNamespace();
    public function getData();
}
