<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\Views;

interface View {
    public function isJson();
    public function hasTemplate();
    public function getTemplate();
}
