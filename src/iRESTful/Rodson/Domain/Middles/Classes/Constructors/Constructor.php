<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors;

interface Constructor {
    public function getName();
    public function hasCustomMethod();
    public function getCustomMethod();
    public function hasParameters();
    public function getParameters();
}
