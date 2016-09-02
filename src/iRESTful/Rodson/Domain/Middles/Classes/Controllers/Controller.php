<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Controllers;

interface Controller {
    public function getName();
    public function getNamespace();
    public function getConstructor();
    public function getCustomMethod();
}
