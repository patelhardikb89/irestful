<?php
namespace iRESTful\Classes\Domain\Constructors;

interface Constructor {
    public function hasCustomMethod();
    public function getCustomMethod();
    public function hasParameters();
    public function getParameters();
}
