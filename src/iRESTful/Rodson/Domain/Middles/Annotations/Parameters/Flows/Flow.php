<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows;

interface Flow {
    public function getPropertyName();
    public function getMethodChain();
    public function getKeyname();
    public function getData();
}
