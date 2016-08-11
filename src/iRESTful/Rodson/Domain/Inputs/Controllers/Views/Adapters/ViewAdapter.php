<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Views\Adapters;

interface ViewAdapter {
    public function fromStringToView($string);
    public function fromDataToView(array $data);
}
