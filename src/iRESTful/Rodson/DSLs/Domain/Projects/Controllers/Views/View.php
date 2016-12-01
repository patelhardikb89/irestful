<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views;

interface View {
    public function isJson();
    public function isText();
    public function hasTemplate();
    public function getTemplate();
}
