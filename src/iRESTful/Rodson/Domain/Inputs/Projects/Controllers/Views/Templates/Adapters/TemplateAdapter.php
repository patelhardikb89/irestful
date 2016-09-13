<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Templates\Adapters;

interface TemplateAdapter {
    public function fromDataToTemplate(array $data);
}
