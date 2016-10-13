<?php
namespace iRESTful\Annotations\Domain;

interface Annotation {
    public function getContainerName();
    public function getParameters();
}
