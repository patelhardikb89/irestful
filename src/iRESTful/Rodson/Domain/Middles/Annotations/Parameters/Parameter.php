<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters;

interface Parameter {
    public function getFlow();
    public function getType();
    public function hasConverter();
    public function getConverter();
    public function hasElementsType();
    public function getElementsType();
}
