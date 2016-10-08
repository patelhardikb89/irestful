<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers;

interface Controller {
    public function getName();
    public function getInputName();
    public function getPattern();
    public function getInstructions();
    public function getView();
    public function getTests();
    public function hasConstants();
    public function getConstants();
    public function hasHttpRequests();
    public function getHttpRequests();
}
