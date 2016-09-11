<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations;

interface Annotation {
    public function getContainerName();
    public function getParameters();
    public function getData();
}
