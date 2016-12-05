<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers;

interface Controller {
    public function getName();
    public function getPattern();
    public function getView();
    public function getFunction();
}
