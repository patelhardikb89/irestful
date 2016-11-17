<?php
namespace iRESTful\Rodson\Annotations\Domain;

interface Annotation {
    public function getContainerName();
    public function getParameters();
}
