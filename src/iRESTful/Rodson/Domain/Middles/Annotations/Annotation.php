<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations;

interface Annotation {
    public function getParameters();
    public function hasContainerName();
    public function getContainerName();
    public function getData();
}
