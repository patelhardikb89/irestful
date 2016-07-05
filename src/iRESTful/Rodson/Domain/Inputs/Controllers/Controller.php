<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers;

interface Controller {
    public function getPattern();
    public function getInstructions();
    public function getView();
}
