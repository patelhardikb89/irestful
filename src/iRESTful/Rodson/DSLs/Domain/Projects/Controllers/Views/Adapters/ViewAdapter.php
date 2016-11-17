<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Adapters;

interface ViewAdapter {
    public function fromStringToView($string);
    public function fromDataToView(array $data);
}
