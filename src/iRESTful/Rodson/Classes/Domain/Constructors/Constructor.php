<?php
namespace iRESTful\Rodson\Classes\Domain\Constructors;

interface Constructor {
    public function hasCustomMethod();
    public function getCustomMethod();
    public function hasParameters();
    public function getParameters();
}
