<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Views;

interface View {
    public function isJson();
    public function hasTemplate();
    public function getTemplate();
}
