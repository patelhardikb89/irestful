<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views;

interface View {
    public function isJson();
    public function hasTemplate();
    public function getTemplate();
}
