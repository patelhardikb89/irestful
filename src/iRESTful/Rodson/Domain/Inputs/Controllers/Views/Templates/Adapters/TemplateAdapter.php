<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Views\Templates\Adapters;

interface TemplateAdapter {
    public function fromDataToTemplate(array $data);
}
