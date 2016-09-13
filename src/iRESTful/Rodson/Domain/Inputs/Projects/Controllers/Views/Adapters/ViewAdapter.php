<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Adapters;

interface ViewAdapter {
    public function fromStringToView($string);
    public function fromDataToView(array $data);
}
